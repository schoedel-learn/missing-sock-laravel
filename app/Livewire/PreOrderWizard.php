<?php

namespace App\Livewire;

use App\Models\School;
use App\Models\Project;
use App\Models\Package;
use App\Models\Registration;
use App\Models\Order;
use App\Models\Child;
use App\Models\User;
use App\Services\UserAccountService;
use Livewire\Component;
use Livewire\WithFileUploads;
use Stripe\Stripe;
use Stripe\Checkout\Session;

class PreOrderWizard extends Component
{
    use WithFileUploads;

    public $currentStep = 1;
    public $totalSteps = 10;

    // Step 1: School Selection & Registration Type
    public $schoolId;
    public $projectId;
    public $selectedProject;
    public $registrationType = 'prepay'; // 'prepay' or 'register_only'
    public $organizationLabel = 'School';
    public $selectedBackdrops = [];
    public $hasTwoBackdrops = false;
    public $projectType;
    public $availableBackdrops = [];
    public $registrationDeadline;

    // Step 2: Parent Information
    public $parentFirstName;
    public $parentLastName;
    public $parentEmail;
    public $parentPhone;
    public $recaptchaVerified = false;

    // Step 3: Children Information
    public $numberOfChildren = 1;
    public $children = [];

    // Step 4: Session Details
    public $siblingSpecial = 'no'; // 'yes' or 'no'
    public $siblingPackageId;
    public $secondSiblingPackageId;
    public $packagePoseDistribution; // 'individuals' or 'together'
    public $siblingSpecialFee = 0; // $5 if yes

    // Step 5: Package Selection
    public $mainPackageId;
    public $secondPackageId;
    public $thirdPackageId;
    public $fourPosesUpgrade = 'no'; // 'yes' or 'no'
    public $fourPosesUpgradePrice = 0; // $10 if yes

    // Step 6: Enhance Your Pack
    public $posePerfection = 'no'; // 'yes' or 'no'
    public $posePerfectionPrice = 0; // $14/$28/$42 based on children
    public $premiumRetouch = 'no'; // 'yes' or 'no'
    public $premiumRetouchPrice = 0; // $12 if yes
    public $retouchSpecification;
    public $classPictureSize;
    public $classPicturePrice = 0;

    // Step 7: Shipping
    public $shippingMethod = 'school'; // 'school' or 'home'
    public $shippingAddress;
    public $shippingAddressLine2;
    public $shippingCity;
    public $shippingState;
    public $shippingZip;
    public $shippingCost = 0; // $7 if home shipping

    // Step 8: Ordering Preferences
    public $autoSelectImages = false;
    public $specialInstructions;
    public $emailOptIn = false;

    // Step 9: Order Summary
    public $subtotal = 0;
    public $discount = 0;
    public $total = 0;

    // Step 10: Confirmation
    public $registrationNumber;
    public $orderNumber;
    public $paymentSessionId;
    public $stripeCheckoutUrl;
    public $pendingOrderId;
    public $pendingRegistrationId;
    public $authorizePayment = false;

    public function mount()
    {
        // Initialize children array
        $this->children = [
            [
                'first_name' => '',
                'last_name' => '',
                'class_name' => '',
                'teacher_name' => '',
                'date_of_birth' => '',
            ]
        ];
    }

    public function updatedSchoolId($value)
    {
        $this->projectId = null;
        $this->selectedProject = null;
        $this->hasTwoBackdrops = false;
        $this->availableBackdrops = [];
        $this->projectType = null;
        $this->registrationDeadline = null;
        $this->organizationLabel = 'School';
        
        if ($value) {
            $school = School::with('currentProject')->find($value);
            if ($school && $school->currentProject) {
                $this->projectId = $school->currentProject->id;
                $this->selectedProject = $school->currentProject;
                $this->hasTwoBackdrops = $school->currentProject->has_two_backdrops ?? false;
                $this->availableBackdrops = $school->currentProject->available_backdrops ?? [];
                $this->projectType = $school->currentProject->type;
                $this->registrationDeadline = $school->currentProject->registration_deadline?->format('m-d-Y');
            }

            if ($school) {
                $this->organizationLabel = $school->display_organization_label;
            }
        }
    }

    public function updatedSelectedBackdrops($value)
    {
        if ($this->hasTwoBackdrops) {
            $this->selectedBackdrops = array_values(array_filter((array) $value));
            return;
        }

        $this->selectedBackdrops = $value ? [$value] : [];
    }

    public function updatedNumberOfChildren($value)
    {
        // Adjust children array
        $currentCount = count($this->children);
        
        if ($value > $currentCount) {
            // Add children
            for ($i = $currentCount; $i < $value; $i++) {
                $this->children[] = [
                    'first_name' => '',
                    'last_name' => '',
                    'class_name' => '',
                    'teacher_name' => '',
                    'date_of_birth' => '',
                ];
            }
        } else {
            // Remove children
            $this->children = array_slice($this->children, 0, $value);
        }
        
        // Recalculate pose perfection price
        $this->updatePosePerfectionPrice();
    }

    public function updatedSiblingSpecial($value)
    {
        if ($value === 'yes') {
            $this->siblingSpecialFee = 500; // $5.00 in cents
        } else {
            $this->siblingSpecialFee = 0;
            $this->siblingPackageId = null;
            $this->secondSiblingPackageId = null;
            $this->packagePoseDistribution = null;
        }
        $this->calculateTotal();
    }

    public function updatedFourPosesUpgrade($value)
    {
        $this->fourPosesUpgradePrice = $value === 'yes' ? 1000 : 0; // $10.00 in cents
        $this->calculateTotal();
    }

    public function updatedPosePerfection($value)
    {
        if ($value === 'yes') {
            $this->updatePosePerfectionPrice();
        } else {
            $this->posePerfectionPrice = 0;
        }
        $this->calculateTotal();
    }

    public function updatePosePerfectionPrice()
    {
        if ($this->posePerfection === 'yes') {
            $prices = [1 => 1400, 2 => 2800, 3 => 4200]; // $14/$28/$42 in cents
            $this->posePerfectionPrice = $prices[$this->numberOfChildren] ?? 0;
        }
    }

    public function updatedPremiumRetouch($value)
    {
        $this->premiumRetouchPrice = $value === 'yes' ? 1200 : 0; // $12.00 in cents
        if ($value === 'no') {
            $this->retouchSpecification = null;
        }
        $this->calculateTotal();
    }

    public function updatedShippingMethod($value)
    {
        if ($value === 'home') {
            $this->shippingCost = 700; // $7.00 in cents
        } else {
            $this->shippingCost = 0;
            $this->shippingAddress = null;
            $this->shippingAddressLine2 = null;
            $this->shippingCity = null;
            $this->shippingState = null;
            $this->shippingZip = null;
        }
        $this->calculateTotal();
    }

    public function updatedMainPackageId()
    {
        $this->calculateTotal();
    }

    public function updatedSecondPackageId()
    {
        $this->calculateTotal();
    }

    public function updatedThirdPackageId()
    {
        $this->calculateTotal();
    }

    public function updatedSiblingPackageId()
    {
        $this->calculateTotal();
    }

    public function updatedSecondSiblingPackageId()
    {
        $this->calculateTotal();
    }

    public function calculateTotal()
    {
        $this->subtotal = 0;

        // Main package
        if ($this->mainPackageId) {
            $package = Package::find($this->mainPackageId);
            $this->subtotal += $package->price_cents ?? 0;
        }

        // Second package (if two backdrops)
        if ($this->secondPackageId) {
            $package = Package::find($this->secondPackageId);
            $this->subtotal += $package->price_cents ?? 0;
        }

        // Third package (if 3 children)
        if ($this->thirdPackageId) {
            $package = Package::find($this->thirdPackageId);
            $this->subtotal += $package->price_cents ?? 0;
        }

        // Sibling packages
        if ($this->siblingPackageId) {
            $package = Package::find($this->siblingPackageId);
            $this->subtotal += $package->price_cents ?? 0;
        }

        if ($this->secondSiblingPackageId) {
            $package = Package::find($this->secondSiblingPackageId);
            $this->subtotal += $package->price_cents ?? 0;
        }

        // Add-ons and upgrades
        $this->subtotal += $this->fourPosesUpgradePrice;
        $this->subtotal += $this->posePerfectionPrice;
        $this->subtotal += $this->premiumRetouchPrice;
        $this->subtotal += $this->classPicturePrice;
        $this->subtotal += $this->siblingSpecialFee;

        // Shipping
        $this->subtotal += $this->shippingCost;

        // Apply discount if any
        $this->total = $this->subtotal - $this->discount;
    }

    public function render()
    {
        $schools = School::where('is_active', true)->orderBy('name')->get();
        $projects = $this->schoolId 
            ? Project::where('school_id', $this->schoolId)
                ->where('is_active', true)
                ->get()
            : collect();
        $packages = Package::where('is_active', true)->orderBy('sort_order')->get();

        // Calculate total whenever render is called
        $this->calculateTotal();

        return view('livewire.pre-order-wizard', [
            'schools' => $schools,
            'projects' => $projects,
            'packages' => $packages,
        ]);
    }

    public function nextStep()
    {
        $this->validateStep();
        if ($this->currentStep < $this->totalSteps) {
            $this->currentStep++;
        }
    }

    public function previousStep()
    {
        if ($this->currentStep > 1) {
            $this->currentStep--;
        }
    }

    public function validateStep()
    {
        switch ($this->currentStep) {
            case 1:
                $this->validate([
                    'schoolId' => 'required|exists:schools,id',
                    'projectId' => 'required|exists:projects,id',
                    'registrationType' => 'required|in:prepay,register_only',
                    'selectedBackdrops' => 'required|array|min:1',
                ], [
                    'selectedBackdrops.required' => 'Please select at least one backdrop.',
                ]);
                break;
            case 2:
                $this->validate([
                    'parentFirstName' => 'required|string|max:255',
                    'parentLastName' => 'required|string|max:255',
                    'parentEmail' => 'required|email|max:255',
                    'parentPhone' => 'required|string|max:20',
                    'recaptchaVerified' => 'accepted',
                ], [
                    'recaptchaVerified.accepted' => 'Please complete the reCAPTCHA verification.',
                ]);
                break;
            case 3:
                $rules = [
                    'numberOfChildren' => 'required|integer|min:1|max:3',
                ];
                foreach ($this->children as $index => $child) {
                    $rules["children.{$index}.first_name"] = 'required|string|max:255';
                    $rules["children.{$index}.last_name"] = 'required|string|max:255';
                    $rules["children.{$index}.class_name"] = 'required|string|max:255';
                    $rules["children.{$index}.date_of_birth"] = 'required|date';
                }
                $this->validate($rules);
                break;
            case 4:
                $rules = [];
                if ($this->siblingSpecial === 'yes') {
                    $rules['siblingPackageId'] = 'required|exists:packages,id';
                    $rules['packagePoseDistribution'] = 'required|in:individuals,together';
                    if ($this->numberOfChildren == 3) {
                        $rules['secondSiblingPackageId'] = 'required|exists:packages,id';
                    }
                }
                if (!empty($rules)) {
                    $this->validate($rules);
                }
                break;
            case 5:
                $rules = [
                    'mainPackageId' => 'required|exists:packages,id',
                ];
                if ($this->hasTwoBackdrops) {
                    $rules['secondPackageId'] = 'required|exists:packages,id';
                }
                if ($this->numberOfChildren == 3) {
                    // Third package is optional but validate if provided
                    if ($this->thirdPackageId) {
                        $rules['thirdPackageId'] = 'exists:packages,id';
                    }
                }
                $this->validate($rules);
                break;
            case 7:
                if ($this->shippingMethod === 'home') {
                    $this->validate([
                        'shippingAddress' => 'required|string|max:255',
                        'shippingCity' => 'required|string|max:255',
                        'shippingState' => 'required|string|size:2',
                        'shippingZip' => 'required|string|max:10',
                    ]);
                }
                break;
        }
    }

    public function submit()
    {
        $this->validateStep();
        
        // Get or create user account
        $userAccountService = app(UserAccountService::class);
        $user = $userAccountService->getOrCreateUser(
            $this->parentEmail,
            $this->parentFirstName,
            $this->parentLastName
        );
        
        // Create registration
        $registration = Registration::create([
            'user_id' => $user->id,
            'school_id' => $this->schoolId,
            'project_id' => $this->projectId,
            'parent_first_name' => $this->parentFirstName,
            'parent_last_name' => $this->parentLastName,
            'parent_email' => $this->parentEmail,
            'parent_phone' => $this->parentPhone,
            'registration_type' => $this->registrationType,
            'number_of_children' => $this->numberOfChildren,
            'sibling_special' => $this->siblingSpecial === 'yes',
            'package_pose_distribution' => $this->packagePoseDistribution,
            'shipping_method' => $this->shippingMethod,
            'shipping_address' => $this->shippingAddress,
            'shipping_address_line2' => $this->shippingAddressLine2,
            'shipping_city' => $this->shippingCity,
            'shipping_state' => $this->shippingState,
            'shipping_zip' => $this->shippingZip,
            'auto_select_images' => $this->autoSelectImages,
            'special_instructions' => $this->specialInstructions,
            'email_opt_in' => $this->emailOptIn,
            'status' => 'pending',
        ]);

        // Create children
        foreach ($this->children as $index => $childData) {
            Child::create([
                'registration_id' => $registration->id,
                'child_number' => $index + 1,
                'first_name' => $childData['first_name'],
                'last_name' => $childData['last_name'],
                'class_name' => $childData['class_name'],
                'teacher_name' => $childData['teacher_name'] ?? null,
                'date_of_birth' => $childData['date_of_birth'] ?? null,
            ]);
        }

        $this->registrationNumber = $registration->registration_number;
        $this->pendingRegistrationId = $registration->id;

        // Handle payment flow
        if ($this->registrationType === 'prepay' && $this->mainPackageId) {
            // Create order first (pending payment)
            $order = Order::create([
                'user_id' => $user->id,
                'registration_id' => $registration->id,
                'main_package_id' => $this->mainPackageId,
                'main_package_price_cents' => Package::find($this->mainPackageId)->price_cents,
                'second_package_id' => $this->secondPackageId,
                'second_package_price_cents' => $this->secondPackageId ? Package::find($this->secondPackageId)->price_cents : null,
                'third_package_id' => $this->thirdPackageId,
                'third_package_price_cents' => $this->thirdPackageId ? Package::find($this->thirdPackageId)->price_cents : null,
                'sibling_package_id' => $this->siblingPackageId,
                'sibling_package_price_cents' => $this->siblingPackageId ? Package::find($this->siblingPackageId)->price_cents : null,
                'sibling_special_fee_cents' => $this->siblingSpecialFee,
                'four_poses_upgrade' => $this->fourPosesUpgrade === 'yes',
                'four_poses_upgrade_price_cents' => $this->fourPosesUpgradePrice,
                'pose_perfection' => $this->posePerfection === 'yes',
                'pose_perfection_price_cents' => $this->posePerfectionPrice,
                'premium_retouch' => $this->premiumRetouch === 'yes',
                'premium_retouch_price_cents' => $this->premiumRetouchPrice,
                'retouch_specification' => $this->retouchSpecification,
                'class_picture_size' => $this->classPictureSize,
                'class_picture_price_cents' => $this->classPicturePrice,
                'subtotal_cents' => $this->subtotal,
                'shipping_cents' => $this->shippingCost,
                'discount_cents' => $this->discount,
                'total_cents' => $this->total,
            ]);

            $this->pendingOrderId = $order->id;
            $this->orderNumber = $order->order_number;
            
            // Create Stripe Checkout Session
            $this->createStripeCheckoutSession($order, $user);
        } else {
            // Register only - no payment needed
            $this->currentStep = 10; // Go to confirmation step
        }
    }

    /**
     * Create Stripe Checkout Session for payment
     */
    protected function createStripeCheckoutSession(Order $order, User $user)
    {
        try {
            Stripe::setApiKey(config('services.stripe.secret'));

            $checkoutSession = Session::create([
                'customer_email' => $user->email,
                'payment_method_types' => ['card'],
                'line_items' => [[
                    'price_data' => [
                        'currency' => 'usd',
                        'product_data' => [
                            'name' => 'Picture Day Order - ' . $order->order_number,
                            'description' => 'School photography pre-order',
                        ],
                        'unit_amount' => $order->total_cents,
                    ],
                    'quantity' => 1,
                ]],
                'mode' => 'payment',
                'success_url' => route('pre-order.payment.success', ['order' => $order->id]) . '?session_id={CHECKOUT_SESSION_ID}',
                'cancel_url' => route('pre-order.payment.cancel', ['order' => $order->id]),
                'metadata' => [
                    'order_id' => $order->id,
                    'registration_id' => $order->registration_id,
                    'user_id' => $user->id,
                ],
            ]);

            $this->paymentSessionId = $checkoutSession->id;
            $this->stripeCheckoutUrl = $checkoutSession->url;
            
            // Move to step 10 to show redirect message
            $this->currentStep = 10;
        } catch (\Exception $e) {
            session()->flash('error', 'Payment processing error: ' . $e->getMessage());
            $this->addError('payment', 'Unable to process payment. Please try again.');
        }
    }
}
