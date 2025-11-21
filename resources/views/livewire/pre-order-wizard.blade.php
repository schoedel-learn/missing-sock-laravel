<div>
    <!-- Progress Bar -->
    <div class="mb-8">
        <div class="flex justify-between mb-2">
            @for($i = 1; $i <= $totalSteps; $i++)
                <div class="flex-1 text-center">
                    <div class="w-10 h-10 mx-auto rounded-full flex items-center justify-center text-sm font-semibold
                        {{ $currentStep >= $i ? 'bg-primary text-white' : 'bg-gray-200 text-gray-600' }}">
                        {{ $i }}
                    </div>
                    @if($i < $totalSteps)
                        <div class="h-1 mt-2 {{ $currentStep > $i ? 'bg-primary' : 'bg-gray-200' }}"></div>
                    @endif
                </div>
            @endfor
        </div>
        <div class="text-center text-sm text-gray-600">
            Step {{ $currentStep }} of {{ $totalSteps }}
        </div>
    </div>

    <!-- Form Card -->
    <div class="bg-white rounded-lg shadow-lg p-8">
        <!-- Validation Errors Display -->
        @if($errors->any())
            <div class="mb-6 bg-red-50 border border-red-200 rounded-lg p-4">
                <h3 class="text-red-800 font-semibold mb-2">Please fix the following errors:</h3>
                <ul class="list-disc list-inside text-sm text-red-700 space-y-1">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if($currentStep == 1)
            <!-- Step 1: Organization Selection & Registration Type -->
            <h2 class="text-2xl font-bold mb-6">{{ $organizationLabel }} Selection & Registration Type</h2>
            
            <div class="space-y-6">
                <!-- School Selection -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Select Your {{ $organizationLabel }} *</label>
                    <select wire:model.live="schoolId" class="w-full border-gray-300 rounded-lg p-2">
                        <option value="">Select a {{ strtolower($organizationLabel) }}...</option>
                        @foreach($schools as $school)
                            <option value="{{ $school->id }}">{{ $school->name }}</option>
                        @endforeach
                    </select>
                    @error('schoolId') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                @if($schoolId && $selectedProject)
                    <!-- Project Info Display -->
                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                        <p class="text-sm text-blue-800">
                            <strong>Project:</strong> {{ $selectedProject->name }}<br>
                            @if($registrationDeadline)
                                <strong>Registration Deadline:</strong> {{ $registrationDeadline }}
                            @endif
                        </p>
                    </div>

                    <!-- Backdrop Selection (Conditional Logic Rule 2) -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            @if($projectType === 'school_graduation')
                                Choose your child's session backdrop: *
                            @elseif($projectType === 'holidays')
                                Choose your child's Holidays backdrop: *
                            @elseif($projectType === 'back_to_school')
                                Select your child's session backdrop: *
                            @elseif($projectType === 'fall')
                                Select your child's session backdrop: *
                            @elseif($projectType === 'winter')
                                Select your child's Winter session backdrop: *
                            @elseif($projectType === 'christmas')
                                Select your child's Christmas session backdrop: *
                            @elseif($projectType === 'spring')
                                Select your child's session backdrop: *
                            @else
                                Select backdrop: *
                            @endif
                        </label>
                        
                        @if($hasTwoBackdrops)
                            <!-- Multiple backdrop options -->
                            <div class="space-y-2">
                                @foreach($availableBackdrops as $backdrop)
                                    <label class="flex items-center">
                                        <input type="checkbox" wire:model="selectedBackdrops" value="{{ $backdrop }}" class="mr-2">
                                        <span>{{ ucfirst($backdrop) }}</span>
                                    </label>
                                @endforeach
                            </div>
                        @else
                            <!-- Single backdrop selection -->
                            <div class="space-y-2">
                                @foreach($availableBackdrops as $backdrop)
                                    <label class="flex items-center">
                                        <input type="radio" wire:model.live="selectedBackdrops" value="{{ $backdrop }}" class="mr-2">
                                        <span>{{ ucfirst($backdrop) }}</span>
                                    </label>
                                @endforeach
                            </div>
                        @endif
                        @error('selectedBackdrops') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <!-- Two Backdrops Warning (Conditional Logic Rule 5) -->
                    @if($hasTwoBackdrops)
                        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                            <p class="text-sm text-yellow-800">
                                ⚠️ The second Pack is mandatory since you have selected two backdrops. Learn more about backdrop selection.
                            </p>
                        </div>
                    @endif
                @endif

                <!-- Registration Type -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Picture Day is Here! How Do You Want to Join? *</label>
                    <div class="space-y-2">
                        <label class="flex items-start p-3 border rounded-lg cursor-pointer hover:bg-gray-50">
                            <input type="radio" wire:model="registrationType" value="prepay" class="mt-1 mr-3">
                            <div>
                                <span class="font-semibold">Prepay and Unlock All Benefits</span>
                                <p class="text-sm text-gray-600">Get exclusive discounts and secure your spot</p>
                            </div>
                        </label>
                        <label class="flex items-start p-3 border rounded-lg cursor-pointer hover:bg-gray-50">
                            <input type="radio" wire:model="registrationType" value="register_only" class="mt-1 mr-3">
                            <div>
                                <span class="font-semibold">Register without Pre-Paying</span>
                                <p class="text-sm text-gray-600">Register now, pay later</p>
                            </div>
                        </label>
                    </div>
                    @error('registrationType') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
            </div>

        @elseif($currentStep == 2)
            <!-- Step 2: Your Information -->
            <h2 class="text-2xl font-bold mb-6">Your Information</h2>
            
            <div class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">First Name *</label>
                        <input type="text" wire:model="parentFirstName" class="w-full border-gray-300 rounded-lg p-2">
                        @error('parentFirstName') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Last Name *</label>
                        <input type="text" wire:model="parentLastName" class="w-full border-gray-300 rounded-lg p-2">
                        @error('parentLastName') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Email Address *</label>
                        <input type="email" wire:model="parentEmail" class="w-full border-gray-300 rounded-lg p-2">
                        @error('parentEmail') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Phone Number *</label>
                        <input type="tel" wire:model="parentPhone" placeholder="(000) 000-0000" class="w-full border-gray-300 rounded-lg p-2">
                        @error('parentPhone') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>
                </div>
                
                <!-- reCAPTCHA Placeholder -->
                <div class="bg-gray-50 border border-gray-200 rounded-lg p-4">
                    <p class="text-sm text-gray-600 mb-2">reCAPTCHA Verification *</p>
                    <div class="bg-green-100 border border-green-300 h-20 rounded flex items-center justify-center">
                        <p class="text-sm text-green-700 font-medium">✓ reCAPTCHA verified (placeholder for development)</p>
                    </div>
                    <input type="hidden" wire:model="recaptchaVerified" value="1">
                    @error('recaptchaVerified') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    <p class="text-xs text-gray-500 mt-2">Note: Real Google reCAPTCHA integration needed for production</p>
                </div>
            </div>

        @elseif($currentStep == 3)
            <!-- Step 3: Your Child's Information (Conditional Logic Rule 3) -->
            <h2 class="text-2xl font-bold mb-6">Your Child's Information</h2>
            
            <div class="space-y-6">
                <!-- Number of Children -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">So, how many kids are we signing up today? *</label>
                    <div class="grid grid-cols-3 gap-4">
                        <label class="flex items-center p-4 border rounded-lg cursor-pointer hover:bg-gray-50">
                            <input type="radio" wire:model.live="numberOfChildren" value="1" class="mr-2">
                            <span>One (1)</span>
                        </label>
                        <label class="flex items-center p-4 border rounded-lg cursor-pointer hover:bg-gray-50">
                            <input type="radio" wire:model.live="numberOfChildren" value="2" class="mr-2">
                            <span>Two (2)</span>
                        </label>
                        <label class="flex items-center p-4 border rounded-lg cursor-pointer hover:bg-gray-50">
                            <input type="radio" wire:model.live="numberOfChildren" value="3" class="mr-2">
                            <span>Three (3)</span>
                        </label>
                    </div>
                    @error('numberOfChildren') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <!-- Child Fields (Dynamic based on numberOfChildren) -->
                @foreach($children as $index => $child)
                <div class="border rounded-lg p-6">
                    <h3 class="text-lg font-semibold mb-4">Child {{ $index + 1 }} Information</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Student's First Name *</label>
                            <input type="text" wire:model="children.{{ $index }}.first_name" class="w-full border-gray-300 rounded-lg p-2">
                            @error("children.{$index}.first_name") <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Student's Last Name *</label>
                            <input type="text" wire:model="children.{{ $index }}.last_name" class="w-full border-gray-300 rounded-lg p-2">
                            @error("children.{$index}.last_name") <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Student's Class Name *</label>
                            <input type="text" wire:model="children.{{ $index }}.class_name" class="w-full border-gray-300 rounded-lg p-2">
                            @error("children.{$index}.class_name") <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Student's Teacher Name</label>
                            <input type="text" wire:model="children.{{ $index }}.teacher_name" class="w-full border-gray-300 rounded-lg p-2">
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Student's Date of Birth *</label>
                            <input type="date" wire:model="children.{{ $index }}.date_of_birth" class="w-full border-gray-300 rounded-lg p-2" max="{{ date('Y-m-d') }}">
                            @error("children.{$index}.date_of_birth") <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

        @elseif($currentStep == 4)
            <!-- Step 4: Session Details (Conditional Logic Rule 4) -->
            <h2 class="text-2xl font-bold mb-6">Session Details</h2>
            
            <div class="space-y-6">
                <!-- Sibling Special -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Do you want to Include the Sibling Special to your session?
                    </label>
                    <div class="space-y-2">
                        <label class="flex items-start p-3 border rounded-lg cursor-pointer hover:bg-gray-50">
                            <input type="radio" wire:model.live="siblingSpecial" value="yes" class="mt-1 mr-3">
                            <div>
                                <span class="font-semibold">Yes, include the Sibling Special</span>
                                <p class="text-sm text-gray-600">Extra $5 and have them pose together</p>
                            </div>
                        </label>
                        <label class="flex items-start p-3 border rounded-lg cursor-pointer hover:bg-gray-50">
                            <input type="radio" wire:model.live="siblingSpecial" value="no" class="mt-1 mr-3">
                            <div>
                                <span class="font-semibold">No</span>
                                <p class="text-sm text-gray-600">I'll purchase separate packs for each child</p>
                            </div>
                        </label>
                    </div>
                </div>

                @if($siblingSpecial === 'yes')
                    <!-- Sibling Package Selection -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Select Your Siblings Package *</label>
                        <div class="space-y-2">
                            @foreach($packages as $package)
                                <label class="flex items-center p-3 border rounded-lg cursor-pointer hover:bg-gray-50">
                                    <input type="radio" wire:model.live="siblingPackageId" value="{{ $package->id }}" class="mr-3">
                                    <div class="flex-1">
                                        <span class="font-semibold">{{ $package->name }}</span>
                                        <span class="text-gray-600 ml-2">- {{ $package->formatted_price }}</span>
                                    </div>
                                </label>
                            @endforeach
                        </div>
                        @error('siblingPackageId') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <!-- Second Sibling Package (if 3 children) -->
                    @if($numberOfChildren == 3)
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Select Your Second Siblings Package *</label>
                            <div class="space-y-2">
                                @foreach($packages as $package)
                                    <label class="flex items-center p-3 border rounded-lg cursor-pointer hover:bg-gray-50">
                                        <input type="radio" wire:model.live="secondSiblingPackageId" value="{{ $package->id }}" class="mr-3">
                                        <div class="flex-1">
                                            <span class="font-semibold">{{ $package->name }}</span>
                                            <span class="text-gray-600 ml-2">- {{ $package->formatted_price }}</span>
                                        </div>
                                    </label>
                                @endforeach
                            </div>
                            @error('secondSiblingPackageId') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                    @endif

                    <!-- Package Pose Distribution -->
                    @if($siblingPackageId)
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Please select your package pose distribution you prefer: *
                            </label>
                            <div class="space-y-2">
                                <label class="flex items-center p-3 border rounded-lg cursor-pointer hover:bg-gray-50">
                                    <input type="radio" wire:model="packagePoseDistribution" value="individuals" class="mr-3">
                                    <span>Yes, include the individuals</span>
                                </label>
                                <label class="flex items-center p-3 border rounded-lg cursor-pointer hover:bg-gray-50">
                                    <input type="radio" wire:model="packagePoseDistribution" value="together" class="mr-3">
                                    <span>No, I want them together</span>
                                </label>
                            </div>
                            @error('packagePoseDistribution') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                    @endif
                @endif
            </div>

        @elseif($currentStep == 5)
            <!-- Step 5: Package Selection -->
            <h2 class="text-2xl font-bold mb-6">Package Selection</h2>
            
            <div class="space-y-6">
                <!-- Main Package -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Select your child's Main Package *</label>
                    <div class="space-y-2">
                        @foreach($packages as $package)
                            <label class="flex items-center p-3 border rounded-lg cursor-pointer hover:bg-gray-50">
                                <input type="radio" wire:model.live="mainPackageId" value="{{ $package->id }}" class="mr-3">
                                <div class="flex-1">
                                    <span class="font-semibold">{{ $package->name }}</span>
                                    <span class="text-gray-600 ml-2">- {{ $package->formatted_price }}</span>
                                    @if($package->description)
                                        <p class="text-sm text-gray-500 mt-1">{{ $package->description }}</p>
                                    @endif
                                </div>
                            </label>
                        @endforeach
                    </div>
                    @error('mainPackageId') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <!-- 4 Poses Digital Upgrade (Conditional Logic Rule 10) -->
                @if($mainPackageId)
                    <div class="border-t pt-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Would you like to upgrade to 4 Poses Digital for only $10?
                        </label>
                        <div class="space-y-2">
                            <label class="flex items-center">
                                <input type="radio" wire:model.live="fourPosesUpgrade" value="yes" class="mr-2">
                                <span>Yes, that would be great!</span>
                            </label>
                            <label class="flex items-center">
                                <input type="radio" wire:model.live="fourPosesUpgrade" value="no" class="mr-2">
                                <span>No, thank you</span>
                            </label>
                        </div>
                    </div>
                @endif

                <!-- Second Package (Conditional Logic Rule 5) -->
                @if($hasTwoBackdrops)
                    <div class="border-t pt-4">
                        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mb-4">
                            <p class="text-sm text-yellow-800">
                                ⚠️ The second Pack is mandatory since you have selected two backdrops.
                            </p>
                        </div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Select your second Package *</label>
                        <div class="space-y-2">
                            @foreach($packages as $package)
                                <label class="flex items-center p-3 border rounded-lg cursor-pointer hover:bg-gray-50">
                                    <input type="radio" wire:model.live="secondPackageId" value="{{ $package->id }}" class="mr-3">
                                    <div class="flex-1">
                                        <span class="font-semibold">{{ $package->name }}</span>
                                        <span class="text-gray-600 ml-2">- {{ $package->formatted_price }}</span>
                                    </div>
                                </label>
                            @endforeach
                        </div>
                        @error('secondPackageId') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>
                @endif

                <!-- Third Package (Conditional Logic Rule 6) -->
                @if($numberOfChildren == 3)
                    <div class="border-t pt-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Third Pack Selection (Optional)</label>
                        <div class="space-y-2">
                            <label class="flex items-center p-3 border rounded-lg cursor-pointer hover:bg-gray-50">
                                <input type="radio" wire:model.live="thirdPackageId" value="" class="mr-3">
                                <span>No third package</span>
                            </label>
                            @foreach($packages as $package)
                                <label class="flex items-center p-3 border rounded-lg cursor-pointer hover:bg-gray-50">
                                    <input type="radio" wire:model.live="thirdPackageId" value="{{ $package->id }}" class="mr-3">
                                    <div class="flex-1">
                                        <span class="font-semibold">{{ $package->name }}</span>
                                        <span class="text-gray-600 ml-2">- {{ $package->formatted_price }}</span>
                                    </div>
                                </label>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Class Picture Size -->
                <div class="border-t pt-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Class Picture Size Selection (Optional)</label>
                    <div class="space-y-2">
                        <label class="flex items-center p-3 border rounded-lg cursor-pointer hover:bg-gray-50">
                            <input type="radio" wire:model.live="classPictureSize" value="8x10" class="mr-3">
                            <span>Print 8x10 - $20</span>
                        </label>
                        <label class="flex items-center p-3 border rounded-lg cursor-pointer hover:bg-gray-50">
                            <input type="radio" wire:model.live="classPictureSize" value="11x14" class="mr-3">
                            <span>Print 11x14 - $24</span>
                        </label>
                        <label class="flex items-center p-3 border rounded-lg cursor-pointer hover:bg-gray-50">
                            <input type="radio" wire:model.live="classPictureSize" value="panorama_5x20" class="mr-3">
                            <span>Print Panorama 5x20 - $40</span>
                        </label>
                        <label class="flex items-center p-3 border rounded-lg cursor-pointer hover:bg-gray-50">
                            <input type="radio" wire:model.live="classPictureSize" value="" class="mr-3">
                            <span>No class picture</span>
                        </label>
                    </div>
                </div>
            </div>

        @elseif($currentStep == 6)
            <!-- Step 6: Enhance Your Pack -->
            <h2 class="text-2xl font-bold mb-6">Enhance Your Pack</h2>
            
            <div class="space-y-6">
                <!-- Pose Perfection (Conditional Logic Rule 7) -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        @if($numberOfChildren == 1)
                            Upgrade to Pose Perfection for Only $14?
                        @elseif($numberOfChildren == 2)
                            Upgrade to Pose Perfection for both your children for Only $28?
                        @else
                            Upgrade to Pose Perfection for each pack for your three children's pack for Only $42?
                        @endif
                    </label>
                    <div class="space-y-2">
                        <label class="flex items-center">
                            <input type="radio" wire:model.live="posePerfection" value="yes" class="mr-2">
                            <span>
                                @if($numberOfChildren == 1)
                                    Yes, include the 2 extra poses
                                @else
                                    Yes, include the 2 poses extras for each pack
                                @endif
                            </span>
                        </label>
                        <label class="flex items-center">
                            <input type="radio" wire:model.live="posePerfection" value="no" class="mr-2">
                            <span>No, Thanks</span>
                        </label>
                    </div>
                </div>

                <!-- Premium Retouch (Conditional Logic Rule 8) -->
                <div class="border-t pt-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Would you like to include the Premium Retouch Service? $12
                    </label>
                    <div class="space-y-2">
                        <label class="flex items-center">
                            <input type="radio" wire:model.live="premiumRetouch" value="yes" class="mr-2">
                            <span>Yes, please</span>
                        </label>
                        <label class="flex items-center">
                            <input type="radio" wire:model.live="premiumRetouch" value="no" class="mr-2">
                            <span>No, Thanks</span>
                        </label>
                    </div>
                </div>

                <!-- Retouch Specification (shown if Premium Retouch = Yes) -->
                @if($premiumRetouch === 'yes')
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Specify what you would like to have retouched?
                        </label>
                        <textarea wire:model="retouchSpecification" rows="3" class="w-full border-gray-300 rounded-lg p-2" placeholder="e.g., Remove scratch on cheek, fix hair, etc."></textarea>
                    </div>
                @endif
            </div>

        @elseif($currentStep == 7)
            <!-- Step 7: Add-Ons -->
            <h2 class="text-2xl font-bold mb-6">Enhance Your Order</h2>
            
            <div class="space-y-6">
                <p class="text-gray-600 mb-4">Select any additional products you'd like to add to your order:</p>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @foreach($addOns as $addOn)
                        <label class="flex items-start p-4 border-2 rounded-lg cursor-pointer hover:border-blue-500 hover:bg-blue-50 transition-all {{ in_array($addOn->id, $selectedAddOns ?? []) ? 'border-blue-500 bg-blue-50' : 'border-gray-200' }}">
                            <input 
                                type="checkbox" 
                                wire:model.live="selectedAddOns" 
                                value="{{ $addOn->id }}" 
                                class="mt-1 mr-3 h-5 w-5 text-blue-600 rounded"
                            >
                            <div class="flex-1">
                                <div class="flex justify-between items-start mb-1">
                                    <span class="font-semibold text-gray-900">{{ $addOn->name }}</span>
                                    <span class="font-bold text-blue-600 ml-2">${{ number_format($addOn->price_cents / 100, 2) }}</span>
                                </div>
                                @if($addOn->description)
                                    <p class="text-sm text-gray-600">{{ $addOn->description }}</p>
                                @endif
                            </div>
                        </label>
                    @endforeach
                </div>

                @if(count($selectedAddOns) > 0)
                    <div class="mt-4 p-4 bg-blue-50 border border-blue-200 rounded-lg">
                        <p class="text-sm text-blue-800">
                            <strong>Add-Ons Selected:</strong> {{ count($selectedAddOns) }} item(s) - 
                            <strong>${{ number_format($addOnsTotal / 100, 2) }}</strong>
                        </p>
                    </div>
                @endif
            </div>

        @elseif($currentStep == 8)
            <!-- Step 8: Shipping (Conditional Logic Rule 9) -->
            <h2 class="text-2xl font-bold mb-6">Shipping</h2>
            
            <div class="space-y-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        What type of shipping method would you prefer to have?
                    </label>
                    <div class="space-y-2">
                        <label class="flex items-start p-3 border rounded-lg cursor-pointer hover:bg-gray-50">
                            <input type="radio" wire:model.live="shippingMethod" value="school" class="mt-1 mr-3">
                            <div>
                                <span class="font-semibold">Free Shipping to the school</span>
                                <p class="text-sm text-gray-600">3 to 4 weeks after the session.</p>
                            </div>
                        </label>
                        <label class="flex items-start p-3 border rounded-lg cursor-pointer hover:bg-gray-50">
                            <input type="radio" wire:model.live="shippingMethod" value="home" class="mt-1 mr-3">
                            <div>
                                <span class="font-semibold">Home Shipping - $7</span>
                                <p class="text-sm text-gray-600">6 to 10 business days after selecting your images</p>
                            </div>
                        </label>
                    </div>
                </div>

                <!-- Shipping Address (shown if Home Shipping) -->
                @if($shippingMethod === 'home')
                    <div class="border-t pt-4">
                        <h3 class="text-lg font-semibold mb-4">Shipping Address *</h3>
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Street Address *</label>
                                <input type="text" wire:model="shippingAddress" class="w-full border-gray-300 rounded-lg p-2">
                                @error('shippingAddress') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Street Address Line 2</label>
                                <input type="text" wire:model="shippingAddressLine2" class="w-full border-gray-300 rounded-lg p-2">
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">City *</label>
                                    <input type="text" wire:model="shippingCity" class="w-full border-gray-300 rounded-lg p-2">
                                    @error('shippingCity') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">State *</label>
                                    <select wire:model="shippingState" class="w-full border-gray-300 rounded-lg p-2">
                                        <option value="">Select state...</option>
                                        <option value="FL">Florida</option>
                                        <option value="AL">Alabama</option>
                                        <!-- Add all 50 states -->
                                    </select>
                                    @error('shippingState') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Zip Code *</label>
                                <input type="text" wire:model="shippingZip" class="w-full border-gray-300 rounded-lg p-2" maxlength="10">
                                @error('shippingZip') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>
                @endif
            </div>

        @elseif($currentStep == 9)
            <!-- Step 9: Ordering Preferences -->
            <h2 class="text-2xl font-bold mb-6">Ordering Preferences</h2>
            
            <div class="space-y-6">
                <!-- Auto Select Images -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        If the 5-day period ends without a selection, would you like us to select your images on your behalf to complete your order? *
                    </label>
                    <div class="space-y-2">
                        <label class="flex items-start p-3 border rounded-lg cursor-pointer hover:bg-gray-50">
                            <input type="radio" wire:model.live="autoSelectImages" value="1" class="mt-1 mr-3">
                            <div>
                                <span class="font-semibold">Yes, please select the images for me</span>
                                <p class="text-sm text-gray-600">if I don't make a selection within 5 days.</p>
                            </div>
                        </label>
                        <label class="flex items-start p-3 border rounded-lg cursor-pointer hover:bg-gray-50">
                            <input type="radio" wire:model.live="autoSelectImages" value="0" class="mt-1 mr-3">
                            <div>
                                <span class="font-semibold">No</span>
                                <p class="text-sm text-gray-600">and I understand that I am responsible for selecting the images and handling shipping fees if I miss the 5-day deadline.</p>
                            </div>
                        </label>
                    </div>
                </div>

                <!-- Special Instructions -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Share your comments, suggestions or instructions
                    </label>
                    <textarea wire:model="specialInstructions" rows="4" class="w-full border-gray-300 rounded-lg p-2" placeholder="Type here... (For example, is there anything in specific that makes your child smile?)"></textarea>
                </div>

                <!-- Email Opt-in -->
                <div>
                    <label class="flex items-center">
                        <input type="checkbox" wire:model="emailOptIn" class="mr-2">
                        <span>I would like to receive email updates about my order</span>
                    </label>
                </div>
            </div>

        @elseif($currentStep == 10)
            <!-- Step 10: Signature & Agreement -->
            <h2 class="text-2xl font-bold mb-6">Photo Session Participation Agreement</h2>
            
            <div class="space-y-6">
                <!-- Agreement Text -->
                <div class="bg-gray-50 border border-gray-200 rounded-lg p-6 max-h-96 overflow-y-auto">
                    <div class="space-y-4 text-sm text-gray-700">
                        <p>
                            <strong>1. Permission to Photograph:</strong> I hereby grant The Missing Sock Photography and its authorized representatives permission to photograph my child(ren) during the scheduled photo session. I understand that these photographs may be used for the purposes of creating prints, digital images, and other products as part of the photography services provided.
                        </p>
                        <p>
                            <strong>2. COPPA Compliance:</strong> I acknowledge that I am the parent or legal guardian of the child(ren) listed in this registration. I understand that The Missing Sock Photography complies with the Children's Online Privacy Protection Act (COPPA) and that any personal information collected will be used solely for the purpose of providing photography services and will not be shared with third parties without my consent.
                        </p>
                        <p>
                            <strong>3. Email Communications:</strong> By providing my email address, I consent to receive email communications regarding my order, including order confirmations, gallery access notifications, shipping updates, and other order-related information. I understand that I may opt-out of marketing emails at any time while still receiving essential order-related communications.
                        </p>
                    </div>
                </div>

                <!-- Agreement Checkbox -->
                <div class="border-t pt-4">
                    <label class="flex items-start">
                        <input 
                            type="checkbox" 
                            wire:model.live="agreementAccepted" 
                            class="mt-1 mr-3 h-5 w-5 text-blue-600 rounded"
                        >
                        <span class="text-sm text-gray-700">
                            I have read and understand the terms and conditions stated above. I agree to the Photo Session Participation Agreement and consent to the photography services as described. *
                        </span>
                    </label>
                    @error('agreementAccepted') 
                        <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> 
                    @enderror
                </div>

                <!-- Signature Pad -->
                <div class="border-t pt-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Digital Signature * <span class="text-gray-500 font-normal">(Please sign below)</span>
                    </label>
                    <div class="border-2 border-gray-300 rounded-lg bg-white" style="position: relative;">
                        <canvas 
                            id="signatureCanvas" 
                            wire:ignore
                            class="w-full cursor-crosshair"
                            style="touch-action: none; min-height: 150px;"
                        ></canvas>
                        <div class="p-3 bg-gray-50 border-t border-gray-200 flex justify-between items-center">
                            <button 
                                type="button" 
                                onclick="clearSignature()" 
                                class="px-4 py-2 text-sm text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50"
                            >
                                Clear
                            </button>
                            <p class="text-xs text-gray-500">Sign with your mouse or touch screen</p>
                        </div>
                    </div>
                    @error('signatureData') 
                        <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> 
                    @enderror
                </div>

                <!-- Coupon Code -->
                <div class="border-t pt-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Coupon Code <span class="text-gray-500 font-normal">(Optional)</span>
                    </label>
                    <div class="flex gap-2">
                        <input 
                            type="text" 
                            wire:model="couponCode" 
                            placeholder="Enter coupon code"
                            class="flex-1 border-gray-300 rounded-lg p-2"
                        >
                        <button 
                            type="button" 
                            wire:click="applyCouponCode"
                            class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors"
                        >
                            Apply
                        </button>
                    </div>
                    @if($couponDiscount > 0)
                        <p class="text-sm text-green-600 mt-2">✓ Coupon applied! Discount: ${{ number_format($couponDiscount / 100, 2) }}</p>
                    @endif
                </div>
            </div>

            <!-- Signature Pad Library -->
            <script src="https://cdn.jsdelivr.net/npm/signature_pad@4.1.7/dist/signature_pad.umd.min.js"></script>
            
            <!-- Signature Pad Script -->
            <script>
                let signaturePad = null;
                let canvas = null;

                document.addEventListener('DOMContentLoaded', function() {
                    canvas = document.getElementById('signatureCanvas');
                    if (canvas && typeof SignaturePad !== 'undefined') {
                        signaturePad = new SignaturePad(canvas, {
                            backgroundColor: 'rgb(255, 255, 255)',
                            penColor: 'rgb(0, 0, 0)',
                            minWidth: 1,
                            maxWidth: 3,
                        });

                        // Resize canvas
                        function resizeCanvas() {
                            const ratio = Math.max(window.devicePixelRatio || 1, 1);
                            canvas.width = canvas.offsetWidth * ratio;
                            canvas.height = canvas.offsetHeight * ratio;
                            canvas.getContext('2d').scale(ratio, ratio);
                            signaturePad.clear();
                        }
                        resizeCanvas();
                        window.addEventListener('resize', resizeCanvas);

                        // Save signature on change
                        signaturePad.addEventListener('endStroke', function() {
                            if (!signaturePad.isEmpty()) {
                                @this.set('signatureData', signaturePad.toDataURL());
                            }
                        });
                    }
                });

                function clearSignature() {
                    if (signaturePad) {
                        signaturePad.clear();
                        @this.set('signatureData', null);
                    }
                }

                // Listen for Livewire updates
                document.addEventListener('livewire:init', () => {
                    Livewire.on('signature-cleared', () => {
                        if (signaturePad) {
                            signaturePad.clear();
                        }
                    });
                });
            </script>

        @elseif($currentStep == 11)
            <!-- Step 11: Order Summary -->
            <h2 class="text-2xl font-bold mb-6">Order Summary</h2>
            
            <div class="space-y-4">
                <!-- Registration Info -->
                <div class="bg-gray-50 rounded-lg p-4">
                    <h3 class="font-semibold mb-2">Registration Information</h3>
                    <p class="text-sm"><strong>School:</strong> {{ $schools->firstWhere('id', $schoolId)?->name ?? 'N/A' }}</p>
                    <p class="text-sm"><strong>Project:</strong> {{ $selectedProject->name ?? 'N/A' }}</p>
                    <p class="text-sm"><strong>Children:</strong> {{ $numberOfChildren }}</p>
                </div>

                <!-- Order Breakdown -->
                <div class="bg-gray-50 rounded-lg p-4">
                    <h3 class="font-semibold mb-4">Order Breakdown</h3>
                    <div class="space-y-2 text-sm">
                        @if($mainPackageId)
                            @php $mainPkg = $packages->firstWhere('id', $mainPackageId); @endphp
                            <div class="flex justify-between">
                                <span>Main Package ({{ $mainPkg->name ?? 'N/A' }}):</span>
                                <span>${{ number_format(($mainPkg->price_cents ?? 0) / 100, 2) }}</span>
                            </div>
                        @endif
                        @if($secondPackageId)
                            @php $secondPkg = $packages->firstWhere('id', $secondPackageId); @endphp
                            <div class="flex justify-between">
                                <span>Second Package ({{ $secondPkg->name ?? 'N/A' }}):</span>
                                <span>${{ number_format(($secondPkg->price_cents ?? 0) / 100, 2) }}</span>
                            </div>
                        @endif
                        @if($thirdPackageId)
                            @php $thirdPkg = $packages->firstWhere('id', $thirdPackageId); @endphp
                            <div class="flex justify-between">
                                <span>Third Package ({{ $thirdPkg->name ?? 'N/A' }}):</span>
                                <span>${{ number_format(($thirdPkg->price_cents ?? 0) / 100, 2) }}</span>
                            </div>
                        @endif
                        @if($siblingPackageId)
                            @php $siblingPkg = $packages->firstWhere('id', $siblingPackageId); @endphp
                            <div class="flex justify-between">
                                <span>Sibling Package ({{ $siblingPkg->name ?? 'N/A' }}):</span>
                                <span>${{ number_format(($siblingPkg->price_cents ?? 0) / 100, 2) }}</span>
                            </div>
                        @endif
                        @if($siblingSpecialFee > 0)
                            <div class="flex justify-between">
                                <span>Sibling Special Fee:</span>
                                <span>${{ number_format($siblingSpecialFee / 100, 2) }}</span>
                            </div>
                        @endif
                        @if($fourPosesUpgradePrice > 0)
                            <div class="flex justify-between">
                                <span>4 Poses Digital Upgrade:</span>
                                <span>${{ number_format($fourPosesUpgradePrice / 100, 2) }}</span>
                            </div>
                        @endif
                        @if($posePerfectionPrice > 0)
                            <div class="flex justify-between">
                                <span>Pose Perfection:</span>
                                <span>${{ number_format($posePerfectionPrice / 100, 2) }}</span>
                            </div>
                        @endif
                        @if($premiumRetouchPrice > 0)
                            <div class="flex justify-between">
                                <span>Premium Retouch:</span>
                                <span>${{ number_format($premiumRetouchPrice / 100, 2) }}</span>
                            </div>
                        @endif
                        @if($classPicturePrice > 0)
                            <div class="flex justify-between">
                                <span>Class Picture:</span>
                                <span>${{ number_format($classPicturePrice / 100, 2) }}</span>
                            </div>
                        @endif
                        @if($addOnsTotal > 0)
                            <div class="flex justify-between pt-2 border-t">
                                <span class="font-medium">Add-Ons:</span>
                                <span>${{ number_format($addOnsTotal / 100, 2) }}</span>
                            </div>
                            @foreach($addOns as $addOn)
                                @if(in_array($addOn->id, $selectedAddOns ?? []))
                                    <div class="flex justify-between text-sm pl-4 text-gray-600">
                                        <span>• {{ $addOn->name }}</span>
                                        <span>${{ number_format($addOn->price_cents / 100, 2) }}</span>
                                    </div>
                                @endif
                            @endforeach
                        @endif
                        @if($shippingCost > 0)
                            <div class="flex justify-between">
                                <span>Shipping:</span>
                                <span>${{ number_format($shippingCost / 100, 2) }}</span>
                            </div>
                        @endif
                        @if($discount > 0)
                            <div class="flex justify-between text-green-600">
                                <span>Discount:</span>
                                <span>-${{ number_format($discount / 100, 2) }}</span>
                            </div>
                        @endif
                        <div class="flex justify-between font-semibold text-lg pt-2 border-t">
                            <span>Total:</span>
                            <span>${{ number_format($total / 100, 2) }}</span>
                        </div>
                    </div>
                </div>
            </div>

        @elseif($currentStep == 12)
            <!-- Step 12: Authorization & Payment / Confirmation -->
            @if($registrationNumber)
                <!-- Confirmation -->
                <div class="text-center">
                    <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </div>
                    <h2 class="text-2xl font-bold mb-4">Registration Complete!</h2>
                    <p class="text-gray-600 mb-6">Thank you for registering for picture day.</p>
                    
                    <div class="bg-gray-50 rounded-lg p-4 mb-4">
                        <p class="text-sm text-gray-600">Registration Number:</p>
                        <p class="text-xl font-semibold">{{ $registrationNumber }}</p>
                    </div>

                    @if($orderNumber)
                        <div class="bg-gray-50 rounded-lg p-4 mb-6">
                            <p class="text-sm text-gray-600">Order Number:</p>
                            <p class="text-xl font-semibold">{{ $orderNumber }}</p>
                        </div>
                    @endif

                    <a href="{{ route('pre-order.confirmation', ['registration' => $registrationNumber]) }}" 
                       class="inline-block bg-primary text-white px-6 py-3 rounded-lg font-semibold hover:bg-primary-hover">
                        View Full Confirmation
                    </a>
                </div>
            @else
                <!-- Payment Step (if prepaying) -->
                <h2 class="text-2xl font-bold mb-6">Authorization & Payment</h2>
                
                @if($registrationType === 'prepay')
                    <div class="space-y-6">
                        <!-- Order Summary -->
                        <div class="bg-gray-50 rounded-lg p-4">
                            <h3 class="font-semibold mb-2">Final Amount Due</h3>
                            <p class="text-3xl font-bold text-primary">${{ number_format($total / 100, 2) }}</p>
                        </div>

                        @if($stripeCheckoutUrl)
                            <!-- Redirecting to Stripe -->
                            <div class="bg-blue-50 border border-blue-200 rounded-lg p-6 text-center">
                                <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-primary mx-auto mb-4"></div>
                                <p class="text-lg font-semibold text-blue-900 mb-2">Redirecting to Secure Payment...</p>
                                <p class="text-sm text-blue-700">You will be redirected to Stripe Checkout to complete your payment.</p>
                                <p class="text-xs text-blue-600 mt-4">Please wait...</p>
                            </div>
                            
                            <script>
                                // Redirect to Stripe Checkout
                                @if($stripeCheckoutUrl)
                                    window.location.href = @js($stripeCheckoutUrl);
                                @endif
                            </script>
                        @else
                            <!-- Payment Processing -->
                            <div class="bg-white border border-gray-200 rounded-lg p-6">
                                <p class="text-sm text-gray-700 mb-4">
                                    Click the button below to proceed to secure payment processing via Stripe.
                                </p>
                                
                                @error('payment')
                                    <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-4">
                                        <p class="text-sm text-red-800">{{ $message }}</p>
                                    </div>
                                @enderror

                                <!-- Terms & Authorization -->
                                <div class="border-t pt-4 mb-4">
                                    <label class="flex items-start">
                                        <input type="checkbox" wire:model="authorizePayment" class="mt-1 mr-2" required>
                                        <span class="text-sm">
                                            I authorize The Missing Sock Photography to charge my payment method for the amount shown above.
                                            I understand that all sales are final and subject to the cancellation and refund policy.
                                        </span>
                                    </label>
                                </div>
                            </div>
                        @endif
                    </div>
                @else
                    <!-- Register Only - No Payment -->
                    <div class="text-center">
                        <p class="text-gray-600 mb-6">You have chosen to register without pre-paying. You will be able to complete your order after picture day.</p>
                    </div>
                @endif
            @endif
        @endif

        <!-- Navigation Buttons -->
        @if($currentStep < 12)
        <div class="flex justify-between mt-8">
            @if($currentStep > 1)
                <button wire:click="previousStep" type="button" class="px-6 py-2 border border-gray-300 rounded-lg hover:bg-gray-50">
                    Previous
                </button>
            @else
                <div></div>
            @endif

            @if($currentStep < 11)
                <button wire:click="nextStep" type="button" class="px-6 py-2 bg-primary text-white rounded-lg hover:bg-primary-hover">
                    Next
                </button>
            @elseif($currentStep == 11)
                <button wire:click="submit" type="button" class="px-6 py-2 bg-primary text-white rounded-lg hover:bg-primary-hover">
                    {{ $registrationType === 'prepay' ? 'Proceed to Payment' : 'Submit Registration' }}
                </button>
            @endif
        </div>
        @endif
    </div>
</div>
