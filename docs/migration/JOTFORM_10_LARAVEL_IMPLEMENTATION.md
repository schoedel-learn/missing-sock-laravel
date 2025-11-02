# Laravel Implementation Guide
## Complete Guide for Migrating JotForm to Laravel with Filament

---

## 🎯 Executive Summary

This guide provides a complete implementation strategy for migrating The Missing Sock's JotForm pre-order system to Laravel using **Filament Forms** as the primary form builder.

### Why Filament?

**Filament Forms** is the BEST choice for this project because:

✅ **Multi-Step Forms (Wizard)** - Built-in wizard component for 10-page flow  
✅ **Reactive Fields** - Perfect for complex conditional logic  
✅ **Beautiful UI** - Modern, customizable design out of the box  
✅ **Livewire Integration** - Real-time updates without page reloads  
✅ **Repeater Fields** - Handle multiple children easily  
✅ **Form Actions** - Custom buttons and validation  
✅ **Excellent Documentation** - Well-maintained and supported  
✅ **Active Community** - Large ecosystem of plugins  

---

## 📦 Recommended Technology Stack

### Core Framework
```bash
Laravel 10.x or 11.x (latest stable)
PHP 8.2+
MySQL 8.0+ or PostgreSQL 15+
Redis 7.0+ (caching & queues)
Node.js 20+ & NPM (for assets)
```

### Primary Packages

**1. Filament (Forms + Admin Panel)**
```bash
composer require filament/filament:"^3.2"
php artisan filament:install --panels
```

**2. Laravel Cashier (Stripe Integration)**
```bash
composer require laravel/cashier:"^15.0"
```

**3. Spatie Laravel Permission (Role Management)**
```bash
composer require spatie/laravel-permission
```

**4. Laravel Sanctum (API Authentication)**
```bash
composer require laravel/sanctum
```

**5. Spatie Laravel Media Library (File/Image Management)**
```bash
composer require spatie/laravel-medialibrary
```

### Supporting Packages

```bash
# Google reCAPTCHA
composer require google/recaptcha

# Email validation
composer require egulias/email-validator

# PDF generation (for invoices)
composer require barryvdh/laravel-dompdf

# Excel export (for reporting)
composer require maatwebsite/excel

# Activity logging
composer require spatie/laravel-activitylog

# Database backups
composer require spatie/laravel-backup

# Query optimization
composer require barryvdh/laravel-debugbar --dev

# Testing
composer require pestphp/pest --dev --with-all-dependencies
composer require pestphp/pest-plugin-laravel --dev
```

---

## 🏗 Project Structure

```
app/
├── Filament/
│   ├── Pages/
│   │   └── PreOrderForm.php          # Main multi-step wizard
│   ├── Resources/
│   │   ├── OrderResource.php         # Admin: Manage orders
│   │   ├── SchoolResource.php        # Admin: Manage schools
│   │   ├── ProjectResource.php       # Admin: Manage projects
│   │   └── CustomerResource.php      # Admin: Manage customers
│   └── Widgets/
│       └── OrderStatsWidget.php      # Dashboard statistics
├── Models/
│   ├── School.php
│   ├── Project.php
│   ├── Registration.php
│   ├── Child.php
│   ├── Order.php
│   ├── Payment.php
│   ├── Package.php
│   ├── AddOn.php
│   ├── Coupon.php
│   └── TimeSlot.php
├── Services/
│   ├── PricingCalculator.php        # Calculate order totals
│   ├── OrderProcessor.php           # Process orders
│   ├── PaymentService.php           # Handle Stripe payments
│   └── EmailService.php             # Send notifications
├── Observers/
│   └── OrderObserver.php            # Order lifecycle events
├── Notifications/
│   ├── OrderConfirmation.php
│   ├── GalleryReady.php
│   └── ImageSelectionReminder.php
└── Http/
    ├── Controllers/
    │   └── WebhookController.php    # Stripe webhooks
    └── Middleware/
        └── VerifyStripeSignature.php
```

---

## 💾 Database Schema

### Migration Files

**1. Schools Table**
```php
Schema::create('schools', function (Blueprint $table) {
    $table->id();
    $table->string('name');
    $table->string('slug')->unique();
    $table->string('address')->nullable();
    $table->string('city')->nullable();
    $table->string('state', 2)->nullable();
    $table->string('zip', 10)->nullable();
    $table->string('contact_name')->nullable();
    $table->string('contact_email')->nullable();
    $table->string('contact_phone')->nullable();
    $table->boolean('is_active')->default(true);
    $table->timestamps();
    $table->softDeletes();
    
    $table->index('is_active');
});
```

**2. Projects Table**
```php
Schema::create('projects', function (Blueprint $table) {
    $table->id();
    $table->foreignId('school_id')->constrained()->cascadeOnDelete();
    $table->string('name'); // "Tiny Planet ❄️ Winter 2025"
    $table->string('slug')->unique();
    $table->enum('type', [
        'school_graduation',
        'holidays',
        'back_to_school',
        'fall',
        'winter',
        'christmas',
        'spring'
    ]);
    $table->json('available_backdrops'); // ["winter"] or ["winter", "christmas"]
    $table->boolean('has_two_backdrops')->default(false);
    $table->date('registration_deadline');
    $table->date('session_date')->nullable();
    $table->boolean('is_active')->default(true);
    $table->text('notes')->nullable();
    $table->timestamps();
    $table->softDeletes();
    
    $table->index(['school_id', 'is_active']);
});
```

**3. Packages Table**
```php
Schema::create('packages', function (Blueprint $table) {
    $table->id();
    $table->string('name'); // "Popular Pair"
    $table->string('slug')->unique(); // "popular_pair"
    $table->text('description')->nullable();
    $table->integer('price_cents'); // Store as cents: 6500 = $65.00
    $table->integer('number_of_poses');
    $table->boolean('includes_prints')->default(true);
    $table->boolean('includes_digital')->default(false);
    $table->json('print_sizes')->nullable(); // ["5x7", "8x10"]
    $table->boolean('is_active')->default(true);
    $table->integer('sort_order')->default(0);
    $table->timestamps();
    
    $table->index('is_active');
});
```

**4. Add-Ons Table**
```php
Schema::create('add_ons', function (Blueprint $table) {
    $table->id();
    $table->string('name'); // "Extra Smiles"
    $table->string('slug')->unique(); // "extra_smiles"
    $table->text('description')->nullable();
    $table->integer('price_cents'); // 1900 = $19.00
    $table->enum('type', ['print', 'digital', 'product', 'service']);
    $table->boolean('is_active')->default(true);
    $table->integer('sort_order')->default(0);
    $table->timestamps();
    
    $table->index(['type', 'is_active']);
});
```

**5. Registrations Table**
```php
Schema::create('registrations', function (Blueprint $table) {
    $table->id();
    $table->string('registration_number')->unique(); // RG-2025-001234
    $table->foreignId('school_id')->constrained();
    $table->foreignId('project_id')->constrained();
    
    // Parent/Guardian Information
    $table->string('parent_first_name');
    $table->string('parent_last_name');
    $table->string('parent_email');
    $table->string('parent_phone');
    
    // Registration Details
    $table->enum('registration_type', ['prepay', 'register_only']);
    $table->integer('number_of_children'); // 1, 2, or 3
    $table->boolean('sibling_special')->default(false);
    $table->string('package_pose_distribution')->nullable();
    
    // Preferences
    $table->enum('shipping_method', ['school', 'home'])->default('school');
    $table->string('shipping_address')->nullable();
    $table->string('shipping_address_line2')->nullable();
    $table->string('shipping_city')->nullable();
    $table->string('shipping_state')->nullable();
    $table->string('shipping_zip')->nullable();
    
    $table->boolean('auto_select_images')->default(false);
    $table->text('special_instructions')->nullable();
    $table->boolean('email_opt_in')->default(false);
    
    // Signature
    $table->text('signature_data')->nullable(); // Base64 image data
    $table->timestamp('signature_date')->nullable();
    
    // Status
    $table->enum('status', [
        'pending',
        'confirmed',
        'session_completed',
        'gallery_ready',
        'images_selected',
        'order_shipped',
        'completed',
        'cancelled'
    ])->default('pending');
    
    $table->timestamps();
    $table->softDeletes();
    
    $table->index(['school_id', 'project_id', 'status']);
    $table->index('parent_email');
});
```

**6. Children Table**
```php
Schema::create('children', function (Blueprint $table) {
    $table->id();
    $table->foreignId('registration_id')->constrained()->cascadeOnDelete();
    $table->integer('child_number'); // 1, 2, or 3
    $table->string('first_name');
    $table->string('last_name');
    $table->string('class_name');
    $table->string('teacher_name')->nullable();
    $table->date('date_of_birth');
    $table->timestamps();
    
    $table->index(['registration_id', 'child_number']);
});
```

**7. Orders Table**
```php
Schema::create('orders', function (Blueprint $table) {
    $table->id();
    $table->string('order_number')->unique(); // ORD-2025-001234
    $table->foreignId('registration_id')->constrained();
    $table->foreignId('child_id')->nullable()->constrained();
    
    // Main Package
    $table->foreignId('main_package_id')->constrained('packages');
    $table->integer('main_package_price_cents');
    
    // Optional Second/Third Packages
    $table->foreignId('second_package_id')->nullable()->constrained('packages');
    $table->integer('second_package_price_cents')->nullable();
    $table->foreignId('third_package_id')->nullable()->constrained('packages');
    $table->integer('third_package_price_cents')->nullable();
    
    // Sibling Package
    $table->foreignId('sibling_package_id')->nullable()->constrained('packages');
    $table->integer('sibling_package_price_cents')->nullable();
    $table->integer('sibling_special_fee_cents')->default(0);
    
    // Upgrades & Services
    $table->boolean('four_poses_upgrade')->default(false);
    $table->integer('four_poses_upgrade_price_cents')->default(0);
    $table->boolean('pose_perfection')->default(false);
    $table->integer('pose_perfection_price_cents')->default(0);
    $table->boolean('premium_retouch')->default(false);
    $table->integer('premium_retouch_price_cents')->default(0);
    $table->string('retouch_specification')->nullable();
    
    // Class Picture
    $table->string('class_picture_size')->nullable();
    $table->integer('class_picture_price_cents')->default(0);
    
    // Add-Ons (many-to-many relationship via pivot table)
    
    // Pricing
    $table->integer('subtotal_cents');
    $table->integer('shipping_cents')->default(0);
    $table->integer('discount_cents')->default(0);
    $table->string('coupon_code')->nullable();
    $table->integer('total_cents');
    
    $table->timestamps();
    $table->softDeletes();
    
    $table->index('registration_id');
    $table->index('order_number');
});
```

**8. Order Add-Ons Pivot Table**
```php
Schema::create('order_add_ons', function (Blueprint $table) {
    $table->id();
    $table->foreignId('order_id')->constrained()->cascadeOnDelete();
    $table->foreignId('add_on_id')->constrained()->cascadeOnDelete();
    $table->integer('quantity')->default(1);
    $table->integer('price_cents'); // Price at time of purchase
    $table->timestamps();
    
    $table->unique(['order_id', 'add_on_id']);
});
```

**9. Payments Table**
```php
Schema::create('payments', function (Blueprint $table) {
    $table->id();
    $table->foreignId('registration_id')->constrained();
    $table->foreignId('order_id')->nullable()->constrained();
    $table->string('payment_number')->unique(); // PAY-2025-001234
    
    // Stripe Details
    $table->string('stripe_payment_intent_id')->unique()->nullable();
    $table->string('stripe_charge_id')->nullable();
    $table->string('stripe_customer_id')->nullable();
    
    // Payment Info
    $table->integer('amount_cents');
    $table->string('currency', 3)->default('usd');
    $table->enum('status', [
        'pending',
        'processing',
        'succeeded',
        'failed',
        'cancelled',
        'refunded'
    ])->default('pending');
    
    // Card Details (last 4 digits only)
    $table->string('card_brand')->nullable(); // visa, mastercard, etc.
    $table->string('card_last4')->nullable();
    
    // Timestamps
    $table->timestamp('paid_at')->nullable();
    $table->timestamp('failed_at')->nullable();
    $table->timestamp('refunded_at')->nullable();
    $table->integer('refund_amount_cents')->nullable();
    
    // Failure Info
    $table->string('failure_code')->nullable();
    $table->text('failure_message')->nullable();
    
    $table->timestamps();
    
    $table->index(['registration_id', 'status']);
    $table->index('stripe_payment_intent_id');
});
```

**10. Time Slots Table**
```php
Schema::create('time_slots', function (Blueprint $table) {
    $table->id();
    $table->foreignId('project_id')->constrained();
    $table->dateTime('slot_datetime');
    $table->integer('max_participants')->default(4);
    $table->integer('current_bookings')->default(0);
    $table->boolean('is_available')->default(true);
    $table->timestamps();
    
    $table->index(['project_id', 'slot_datetime']);
});
```

**11. Time Slot Bookings Table**
```php
Schema::create('time_slot_bookings', function (Blueprint $table) {
    $table->id();
    $table->foreignId('time_slot_id')->constrained()->cascadeOnDelete();
    $table->foreignId('registration_id')->constrained()->cascadeOnDelete();
    $table->enum('status', ['booked', 'cancelled', 'completed'])->default('booked');
    $table->timestamp('cancelled_at')->nullable();
    $table->timestamps();
    
    $table->index(['time_slot_id', 'status']);
    $table->index('registration_id');
});
```

**12. Coupons Table**
```php
Schema::create('coupons', function (Blueprint $table) {
    $table->id();
    $table->string('code')->unique();
    $table->string('description')->nullable();
    $table->enum('type', ['percentage', 'fixed_amount']);
    $table->integer('value'); // Percentage (0-100) or cents
    $table->integer('minimum_order_cents')->nullable();
    $table->integer('max_uses')->nullable();
    $table->integer('times_used')->default(0);
    $table->date('valid_from')->nullable();
    $table->date('valid_until')->nullable();
    $table->boolean('is_active')->default(true);
    $table->timestamps();
    
    $table->index(['code', 'is_active']);
});
```

---

## 📝 Model Relationships

### School Model
```php
class School extends Model
{
    public function projects()
    {
        return $this->hasMany(Project::class);
    }
    
    public function currentProject()
    {
        return $this->hasOne(Project::class)
            ->where('is_active', true)
            ->latest('registration_deadline');
    }
    
    public function registrations()
    {
        return $this->hasMany(Registration::class);
    }
}
```

### Project Model
```php
class Project extends Model
{
    protected $casts = [
        'available_backdrops' => 'array',
        'registration_deadline' => 'date',
        'session_date' => 'date',
        'has_two_backdrops' => 'boolean',
        'is_active' => 'boolean',
    ];
    
    public function school()
    {
        return $this->belongsTo(School::class);
    }
    
    public function registrations()
    {
        return $this->hasMany(Registration::class);
    }
    
    public function timeSlots()
    {
        return $this->hasMany(TimeSlot::class);
    }
    
    public function availableTimeSlots()
    {
        return $this->hasMany(TimeSlot::class)
            ->where('is_available', true)
            ->where('current_bookings', '<', DB::raw('max_participants'))
            ->orderBy('slot_datetime');
    }
}
```

### Registration Model
```php
class Registration extends Model
{
    protected $casts = [
        'number_of_children' => 'integer',
        'sibling_special' => 'boolean',
        'auto_select_images' => 'boolean',
        'email_opt_in' => 'boolean',
        'signature_date' => 'datetime',
    ];
    
    public function school()
    {
        return $this->belongsTo(School::class);
    }
    
    public function project()
    {
        return $this->belongsTo(Project::class);
    }
    
    public function children()
    {
        return $this->hasMany(Child::class);
    }
    
    public function orders()
    {
        return $this->hasMany(Order::class);
    }
    
    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
    
    public function timeSlotBooking()
    {
        return $this->hasOne(TimeSlotBooking::class);
    }
    
    // Generate unique registration number
    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($registration) {
            $registration->registration_number = 'RG-' . now()->year . '-' . str_pad(
                static::whereYear('created_at', now()->year)->count() + 1,
                6,
                '0',
                STR_PAD_LEFT
            );
        });
    }
}
```

### Order Model
```php
class Order extends Model
{
    protected $casts = [
        'four_poses_upgrade' => 'boolean',
        'pose_perfection' => 'boolean',
        'premium_retouch' => 'boolean',
        'main_package_price_cents' => 'integer',
        'subtotal_cents' => 'integer',
        'total_cents' => 'integer',
    ];
    
    public function registration()
    {
        return $this->belongsTo(Registration::class);
    }
    
    public function child()
    {
        return $this->belongsTo(Child::class);
    }
    
    public function mainPackage()
    {
        return $this->belongsTo(Package::class, 'main_package_id');
    }
    
    public function secondPackage()
    {
        return $this->belongsTo(Package::class, 'second_package_id');
    }
    
    public function addOns()
    {
        return $this->belongsToMany(AddOn::class, 'order_add_ons')
            ->withPivot(['quantity', 'price_cents'])
            ->withTimestamps();
    }
    
    // Accessors for money formatting
    public function getTotalAttribute()
    {
        return $this->total_cents / 100;
    }
    
    public function getFormattedTotalAttribute()
    {
        return '$' . number_format($this->total_cents / 100, 2);
    }
    
    // Generate unique order number
    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($order) {
            $order->order_number = 'ORD-' . now()->year . '-' . str_pad(
                static::whereYear('created_at', now()->year)->count() + 1,
                6,
                '0',
                STR_PAD_LEFT
            );
        });
    }
}
```

---

## 🎨 Filament Pre-Order Form (Wizard)

### Main Form Component

**File:** `app/Filament/Pages/PreOrderForm.php`

```php
<?php

namespace App\Filament\Pages;

use Filament\Forms;
use Filament\Forms\Components\Wizard;
use Filament\Pages\Page;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use App\Models\School;
use App\Models\Package;
use App\Models\AddOn;
use App\Services\PricingCalculator;
use Illuminate\Support\Facades\DB;

class PreOrderForm extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-camera';
    protected static string $view = 'filament.pages.pre-order-form';
    protected static ?string $title = 'School Picture Pre-Order';
    
    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill();
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Wizard::make([
                    // Step 1: School Selection & Registration Type
                    Wizard\Step::make('School & Registration')
                        ->schema($this->getSchoolSelectionSchema())
                        ->columns(2),
                    
                    // Step 2: Your Information
                    Wizard\Step::make('Your Information')
                        ->schema($this->getParentInformationSchema())
                        ->columns(2),
                    
                    // Step 3: Children Information
                    Wizard\Step::make('Children Information')
                        ->schema($this->getChildrenInformationSchema()),
                    
                    // Step 4: Session Details
                    Wizard\Step::make('Session Details')
                        ->schema($this->getSessionDetailsSchema()),
                    
                    // Step 5: Package Selection
                    Wizard\Step::make('Package Selection')
                        ->schema($this->getPackageSelectionSchema())
                        ->columns(2),
                    
                    // Step 6: Enhance Your Pack
                    Wizard\Step::make('Enhance Your Pack')
                        ->schema($this->getEnhancementsSchema())
                        ->columns(2),
                    
                    // Step 7: Shipping
                    Wizard\Step::make('Shipping')
                        ->schema($this->getShippingSchema())
                        ->columns(2),
                    
                    // Step 8: Ordering Preferences
                    Wizard\Step::make('Preferences')
                        ->schema($this->getPreferencesSchema()),
                    
                    // Step 9: Order Summary
                    Wizard\Step::make('Order Summary')
                        ->schema($this->getOrderSummarySchema()),
                    
                    // Step 10: Authorization & Payment
                    Wizard\Step::make('Payment')
                        ->schema($this->getPaymentSchema()),
                ])
                ->submitAction(new HtmlString('<button type="submit">Submit Pre-Order</button>'))
                ->skippable(false)
                ->persistStepInQueryString()
            ])
            ->statePath('data');
    }

    protected function getSchoolSelectionSchema(): array
    {
        return [
            Forms\Components\Select::make('school_id')
                ->label('Select Your Child\'s School')
                ->options(School::where('is_active', true)->pluck('name', 'id'))
                ->searchable()
                ->required()
                ->reactive()
                ->afterStateUpdated(function ($state, Forms\Set $set, Forms\Get $get) {
                    $school = School::with('currentProject')->find($state);
                    
                    if ($school && $school->currentProject) {
                        $project = $school->currentProject;
                        $set('project_id', $project->id);
                        $set('registration_deadline', $project->registration_deadline->format('m-d-Y'));
                        $set('has_two_backdrops', $project->has_two_backdrops);
                        $set('assigned_project_name', $project->name);
                        $set('project_type', $project->type);
                        $set('available_backdrops', $project->available_backdrops);
                    }
                }),
            
            Forms\Components\Hidden::make('project_id'),
            Forms\Components\Hidden::make('registration_deadline'),
            Forms\Components\Hidden::make('has_two_backdrops'),
            Forms\Components\Hidden::make('assigned_project_name'),
            Forms\Components\Hidden::make('project_type'),
            Forms\Components\Hidden::make('available_backdrops'),
            
            // Backdrop selection (conditional based on project type)
            // See JOTFORM_04_CONDITIONAL_LOGIC.md for all variants
            
            Forms\Components\Radio::make('registration_type')
                ->label('Picture Day is Here! How Do You Want to Join?')
                ->options([
                    'prepay' => 'Prepay and Unlock All Benefits',
                    'register_only' => 'Register without Pre-Paying',
                ])
                ->default('prepay')
                ->required()
                ->reactive(),
        ];
    }

    protected function getParentInformationSchema(): array
    {
        return [
            Forms\Components\TextInput::make('parent_first_name')
                ->label('First Name')
                ->required(),
            
            Forms\Components\TextInput::make('parent_last_name')
                ->label('Last Name')
                ->required(),
            
            Forms\Components\TextInput::make('parent_email')
                ->label('Email Address')
                ->email()
                ->required(),
            
            Forms\Components\TextInput::make('parent_phone')
                ->label('Phone Number')
                ->tel()
                ->mask('(999) 999-9999')
                ->placeholder('(000) 000-0000')
                ->required(),
        ];
    }

    protected function getChildrenInformationSchema(): array
    {
        return [
            Forms\Components\Radio::make('number_of_children')
                ->label('So, how many kids are we signing up today?')
                ->options([
                    1 => 'One (1)',
                    2 => 'Two (2)',
                    3 => 'Three (3)',
                ])
                ->default(1)
                ->required()
                ->reactive(),
            
            // Child 1 (always visible)
            Forms\Components\Section::make('Child 1 Information')
                ->schema([
                    Forms\Components\TextInput::make('child1_first_name')->required(),
                    Forms\Components\TextInput::make('child1_last_name')->required(),
                    Forms\Components\TextInput::make('child1_class_name')->required(),
                    Forms\Components\TextInput::make('child1_teacher_name'),
                    Forms\Components\DatePicker::make('child1_date_of_birth')
                        ->required()
                        ->maxDate(now()),
                ])
                ->columns(2),
            
            // Child 2 (conditional)
            Forms\Components\Section::make('Child 2 Information')
                ->schema([
                    Forms\Components\TextInput::make('child2_first_name')->required(),
                    Forms\Components\TextInput::make('child2_last_name')->required(),
                    Forms\Components\TextInput::make('child2_class_name')->required(),
                    Forms\Components\TextInput::make('child2_teacher_name'),
                    Forms\Components\DatePicker::make('child2_date_of_birth')
                        ->required()
                        ->maxDate(now()),
                ])
                ->columns(2)
                ->visible(fn (Forms\Get $get) => $get('number_of_children') >= 2),
            
            // Child 3 (conditional)
            Forms\Components\Section::make('Child 3 Information')
                ->schema([
                    Forms\Components\TextInput::make('child3_first_name')->required(),
                    Forms\Components\TextInput::make('child3_last_name')->required(),
                    Forms\Components\TextInput::make('child3_class_name')->required(),
                    Forms\Components\TextInput::make('child3_teacher_name'),
                    Forms\Components\DatePicker::make('child3_date_of_birth')
                        ->required()
                        ->maxDate(now()),
                ])
                ->columns(2)
                ->visible(fn (Forms\Get $get) => $get('number_of_children') >= 3),
        ];
    }

    // Additional schema methods...
    // See JOTFORM_04_CONDITIONAL_LOGIC.md for complete implementation

    public function submit()
    {
        $data = $this->form->getState();
        
        DB::transaction(function () use ($data) {
            // Create Registration
            $registration = Registration::create([
                'school_id' => $data['school_id'],
                'project_id' => $data['project_id'],
                'parent_first_name' => $data['parent_first_name'],
                'parent_last_name' => $data['parent_last_name'],
                'parent_email' => $data['parent_email'],
                'parent_phone' => $data['parent_phone'],
                'registration_type' => $data['registration_type'],
                'number_of_children' => $data['number_of_children'],
                'sibling_special' => $data['sibling_special'] ?? false,
                // ... more fields
            ]);
            
            // Create Children
            for ($i = 1; $i <= $data['number_of_children']; $i++) {
                $registration->children()->create([
                    'child_number' => $i,
                    'first_name' => $data["child{$i}_first_name"],
                    'last_name' => $data["child{$i}_last_name"],
                    'class_name' => $data["child{$i}_class_name"],
                    'teacher_name' => $data["child{$i}_teacher_name"] ?? null,
                    'date_of_birth' => $data["child{$i}_date_of_birth"],
                ]);
            }
            
            // Create Orders
            $calculator = app(PricingCalculator::class);
            $orderData = $calculator->calculate($data);
            
            $order = Order::create([
                'registration_id' => $registration->id,
                'main_package_id' => $data['main_package_id'],
                // ... all pricing fields
                'total_cents' => $orderData['total_cents'],
            ]);
            
            // Process Payment if prepaying
            if ($data['registration_type'] === 'prepay') {
                $paymentService = app(PaymentService::class);
                $payment = $paymentService->processPayment($registration, $order, $data);
            }
            
            // Send confirmation email
            $registration->notify(new OrderConfirmation($registration, $order));
        });
        
        return redirect()->route('order.success');
    }
}
```

---

## 💰 Pricing Calculator Service

**File:** `app/Services/PricingCalculator.php`

```php
<?php

namespace App\Services;

class PricingCalculator
{
    protected array $packagePrices = [
        'single_smile' => 4800, // $48.00 in cents
        'popular_pair' => 6500,
        'picture_perfect' => 7900,
        'digital_duo' => 5500,
        'triple_treat' => 6500,
        'fantastic_four' => 12400,
    ];
    
    protected array $addOnPrices = [
        'extra_smiles' => 1900,
        'big_moments' => 1900,
        'class_picture_8x10' => 2000,
        'digital_add_on' => 2000,
        'memory_mug' => 2200,
    ];
    
    protected array $classPicturePrices = [
        '8x10' => 2000,
        '11x14' => 2400,
        'panorama_5x20' => 4000,
    ];
    
    public function calculate(array $data): array
    {
        $subtotal = 0;
        
        // Main package
        $subtotal += $this->packagePrices[$data['main_package']] ?? 0;
        
        // Second package (if two backdrops)
        if (!empty($data['second_package'])) {
            $subtotal += $this->packagePrices[$data['second_package']] ?? 0;
        }
        
        // Third package (if three children)
        if (!empty($data['third_package'])) {
            $subtotal += $this->packagePrices[$data['third_package']] ?? 0;
        }
        
        // Sibling special
        if ($data['sibling_special'] ?? false) {
            $subtotal += 500; // $5.00
            $subtotal += $this->packagePrices[$data['sibling_package']] ?? 0;
            
            if ($data['number_of_children'] == 3 && !empty($data['second_sibling_package'])) {
                $subtotal += $this->packagePrices[$data['second_sibling_package']] ?? 0;
            }
        }
        
        // 4 Poses Digital Upgrade
        if ($data['four_poses_upgrade'] === 'yes') {
            $subtotal += 1000; // $10.00
        }
        
        // Pose Perfection (varies by number of children)
        if ($data['pose_perfection'] === 'yes') {
            $numChildren = $data['number_of_children'] ?? 1;
            $posePerfectionPrices = [1 => 1400, 2 => 2800, 3 => 4200];
            $subtotal += $posePerfectionPrices[$numChildren] ?? 0;
        }
        
        // Premium Retouch
        if ($data['premium_retouch'] === 'yes') {
            $subtotal += 1200; // $12.00
        }
        
        // Add-Ons
        foreach ($this->addOnPrices as $key => $price) {
            if (in_array($key, $data['add_ons'] ?? [])) {
                $subtotal += $price;
            }
        }
        
        // Class Picture
        if (!empty($data['class_picture_size'])) {
            $subtotal += $this->classPicturePrices[$data['class_picture_size']] ?? 0;
        }
        
        // Shipping
        $shippingCents = $data['shipping_method'] === 'home' ? 700 : 0;
        
        // Discount (coupon)
        $discountCents = $this->calculateDiscount($data['coupon_code'] ?? null, $subtotal);
        
        // Total
        $totalCents = $subtotal + $shippingCents - $discountCents;
        
        return [
            'subtotal_cents' => $subtotal,
            'shipping_cents' => $shippingCents,
            'discount_cents' => $discountCents,
            'total_cents' => $totalCents,
        ];
    }
    
    protected function calculateDiscount(?string $couponCode, int $subtotal): int
    {
        if (!$couponCode) {
            return 0;
        }
        
        $coupon = Coupon::where('code', $couponCode)
            ->where('is_active', true)
            ->first();
        
        if (!$coupon || !$coupon->isValid($subtotal)) {
            return 0;
        }
        
        if ($coupon->type === 'percentage') {
            return (int) ($subtotal * ($coupon->value / 100));
        }
        
        return $coupon->value; // Fixed amount in cents
    }
}
```

---

## 📧 Email Notifications

**File:** `app/Notifications/OrderConfirmation.php`

```php
<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use App\Models\Registration;
use App\Models\Order;

class OrderConfirmation extends Notification
{
    public function __construct(
        public Registration $registration,
        public Order $order
    ) {}
    
    public function via($notifiable): array
    {
        return ['mail'];
    }
    
    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Picture Day Pre-Order Confirmation - ' . $this->registration->registration_number)
            ->greeting('Hello ' . $this->registration->parent_first_name . '!')
            ->line('Thank you for pre-ordering your school pictures!')
            ->line('Registration Number: ' . $this->registration->registration_number)
            ->line('Order Total: ' . $this->order->formatted_total)
            ->action('View Order Details', route('registration.show', $this->registration))
            ->line('We look forward to capturing beautiful memories of your child!');
    }
}
```

---

## 🎯 Next Steps

1. **Install Laravel & Filament**
```bash
composer create-project laravel/laravel missing-sock-photos
cd missing-sock-photos
composer require filament/filament:"^3.2"
php artisan filament:install --panels
```

2. **Set up database and run migrations**

3. **Seed schools data** (from JOTFORM_02_SCHOOLS_DATA.md)

4. **Build the Filament form** (use JOTFORM_04_CONDITIONAL_LOGIC.md)

5. **Implement Stripe integration**

6. **Create admin panel** for order management

7. **Test thoroughly** with all conditional paths

8. **Deploy** and migrate data

---

**Document Status:** ✅ Complete  
**Last Updated:** November 1, 2025  
**Version:** 1.0

