# Conditional Logic Rules - Complete Reference

**Purpose:** Document all conditional show/hide logic for Laravel implementation

---

## 🎯 Overview

The JotForm uses **11 primary conditional logic rules** that control field visibility and behavior based on user selections. This document provides detailed specifications for each rule.

---

## Implementation Recommendation

### Using Filament Forms

Filament provides multiple ways to handle conditional logic:

1. **`hidden()` / `visible()` methods** - Simple show/hide
2. **`reactive()` method** - Field triggers updates
3. **`afterStateUpdated()` callback** - Run logic when field changes
4. **`dependsOn()` method** - Watch other fields
5. **`live()` method** - Real-time updates

### Example Pattern:

```php
Select::make('number_of_children')
    ->options([
        1 => 'One (1)',
        2 => 'Two (2)',
        3 => 'Three (3)',
    ])
    ->default(1)
    ->reactive(), // Makes field trigger updates

// Child 2 fields - shown only if 2+ children
TextInput::make('child2_first_name')
    ->visible(fn (Get $get) => $get('number_of_children') >= 2)
    ->required(fn (Get $get) => $get('number_of_children') >= 2),
```

---

## Rule 1: School Selection → Project Configuration

### Trigger
When user selects a school from dropdown

### Actions
1. Auto-populate "Registration Deadline" (hidden field)
2. Set "Has Two Backdrops?" flag (Yes/No)
3. Set "Assigned Project Name" (e.g., "Tiny Planet ❄️ Winter 2025")
4. Show appropriate backdrop selection field(s) based on project type

### Data Structure
```json
{
  "school_id": 149,
  "school_name": "Tiny Planet",
  "project_name": "Tiny Planet ❄️ Winter 2025",
  "registration_deadline": "2025-12-15",
  "has_two_backdrops": false,
  "project_type": "winter",
  "available_backdrops": ["Winter"]
}
```

### Laravel Implementation
```php
// In form component
Select::make('school_id')
    ->options(School::pluck('name', 'id'))
    ->reactive()
    ->afterStateUpdated(function ($state, Set $set, Get $get) {
        $school = School::with('currentProject')->find($state);
        
        if ($school && $school->currentProject) {
            $set('registration_deadline', $school->currentProject->deadline);
            $set('has_two_backdrops', $school->currentProject->has_two_backdrops);
            $set('assigned_project_name', $school->currentProject->name);
            $set('project_type', $school->currentProject->type);
        }
    }),

// Hidden fields
Hidden::make('registration_deadline'),
Hidden::make('has_two_backdrops'),
Hidden::make('assigned_project_name'),
Hidden::make('project_type'),
```

---

## Rule 2: Project Type → Backdrop Selection Fields

### Trigger
Based on project type from school selection

### Actions
Show specific backdrop field(s) with appropriate options

### Variants

#### A. School Pictures/Graduation
```php
CheckboxList::make('backdrops')
    ->label('Choose your child\'s session backdrop:')
    ->options([
        'school_picture' => 'School Picture',
        'graduation' => 'Graduation',
    ])
    ->required()
    ->visible(fn (Get $get) => $get('project_type') === 'school_graduation'),
```

#### B. Holidays (Winter + Christmas)
```php
CheckboxList::make('backdrops')
    ->label('Choose your child\'s Holidays backdrop:')
    ->options([
        'winter' => 'Winter',
        'christmas' => 'Christmas',
    ])
    ->required()
    ->visible(fn (Get $get) => $get('project_type') === 'holidays'),
```

#### C. Back To School
```php
Checkbox::make('backdrop_back_to_school')
    ->label('Back To School')
    ->required()
    ->visible(fn (Get $get) => $get('project_type') === 'back_to_school'),
```

#### D. Fall
```php
Checkbox::make('backdrop_fall')
    ->label('Fall')
    ->required()
    ->visible(fn (Get $get) => $get('project_type') === 'fall'),
```

#### E. Winter (single)
```php
Checkbox::make('backdrop_winter')
    ->label('Winter')
    ->required()
    ->visible(fn (Get $get) => $get('project_type') === 'winter'),
```

#### F. Christmas (single)
```php
Checkbox::make('backdrop_christmas')
    ->label('Christmas')
    ->required()
    ->visible(fn (Get $get) => $get('project_type') === 'christmas'),
```

#### G. Spring
```php
Checkbox::make('backdrop_spring')
    ->label('Spring')
    ->required()
    ->visible(fn (Get $get) => $get('project_type') === 'spring'),
```

### Database Schema Suggestion
```php
// projects table
Schema::create('projects', function (Blueprint $table) {
    $table->id();
    $table->foreignId('school_id');
    $table->string('name'); // "Tiny Planet ❄️ Winter 2025"
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
    $table->timestamps();
});
```

---

## Rule 3: Number of Children → Child Fields Visibility

### Trigger
User selects number of children: 1, 2, or 3

### Actions
Dynamically show child information fields

### Implementation
```php
Radio::make('number_of_children')
    ->label('So, how many kids are we signing up today?')
    ->options([
        1 => 'One (1)',
        2 => 'Two (2)',
        3 => 'Three (3)',
    ])
    ->default(1)
    ->reactive()
    ->required(),

// Child 1 (always visible)
Section::make('Child 1 Information')
    ->schema([
        TextInput::make('child1_first_name')
            ->label('Student\'s First Name')
            ->required(),
        TextInput::make('child1_last_name')
            ->label('Student\'s Last Name')
            ->required(),
        TextInput::make('child1_class_name')
            ->label('Student\'s Class Name')
            ->required(),
        TextInput::make('child1_teacher_name')
            ->label('Student\'s Teacher Name'),
        DatePicker::make('child1_date_of_birth')
            ->label('Student\'s Date of Birth')
            ->required()
            ->maxDate(now()),
    ]),

// Child 2 (visible if 2+ children)
Section::make('Child 2 Information')
    ->schema([
        TextInput::make('child2_first_name')
            ->label('Student\'s First Name')
            ->required(),
        TextInput::make('child2_last_name')
            ->label('Student\'s Last Name')
            ->required(),
        TextInput::make('child2_class_name')
            ->label('Student\'s Class Name')
            ->required(),
        TextInput::make('child2_teacher_name')
            ->label('Student\'s Teacher Name'),
        DatePicker::make('child2_date_of_birth')
            ->label('Student\'s Date of Birth')
            ->required()
            ->maxDate(now()),
    ])
    ->visible(fn (Get $get) => $get('number_of_children') >= 2),

// Child 3 (visible if 3 children)
Section::make('Child 3 Information')
    ->schema([
        TextInput::make('child3_first_name')
            ->label('Student\'s First Name')
            ->required(),
        TextInput::make('child3_last_name')
            ->label('Student\'s Last Name')
            ->required(),
        TextInput::make('child3_class_name')
            ->label('Student\'s Class Name')
            ->required(),
        TextInput::make('child3_teacher_name')
            ->label('Student\'s Teacher Name'),
        DatePicker::make('child3_date_of_birth')
            ->label('Student\'s Date of Birth')
            ->required()
            ->maxDate(now()),
    ])
    ->visible(fn (Get $get) => $get('number_of_children') >= 3),
```

---

## Rule 4: Sibling Special → Sibling Package Fields

### Trigger
User selects "Yes, include the Sibling Special"

### Actions
1. Show "Select Your Siblings Package" field
2. Show package pose distribution field
3. If 3 children: Show "Second Siblings Package" field
4. Add $5 to total

### Implementation
```php
Radio::make('sibling_special')
    ->label('Do you want to Include the Sibling Special to your session?')
    ->options([
        'yes' => 'Yes, include the Sibling Special for an extra $5 and have them pose together',
        'no' => 'No, I\'ll purchase separate packs for each child',
    ])
    ->reactive()
    ->afterStateUpdated(function ($state, Set $set) {
        if ($state === 'yes') {
            $set('sibling_special_fee', 5);
        } else {
            $set('sibling_special_fee', 0);
            $set('sibling_package', null);
            $set('second_sibling_package', null);
        }
    }),

// First sibling package
Radio::make('sibling_package')
    ->label('Select Your Siblings Package')
    ->options([
        'popular_pair' => 'Popular Pair - $65',
        'picture_perfect' => 'Picture Perfect - $79',
        'digital_duo' => 'Digital Duo - $55',
        'triple_treat' => 'Triple Treat - $65',
        'fantastic_four' => 'Fantastic Four - $124',
    ])
    ->visible(fn (Get $get) => $get('sibling_special') === 'yes')
    ->required(fn (Get $get) => $get('sibling_special') === 'yes')
    ->reactive(),

// Package pose distribution
Radio::make('package_pose_distribution')
    ->label('Please select your package pose distribution you prefer:')
    ->options([
        'individuals' => 'Yes, include the individuals',
        'together' => 'No, I want them together',
    ])
    ->visible(fn (Get $get) => $get('sibling_special') === 'yes' && $get('sibling_package'))
    ->required(fn (Get $get) => $get('sibling_special') === 'yes' && $get('sibling_package')),

// Second sibling package (for 3 children)
Radio::make('second_sibling_package')
    ->label('Select Your Second Siblings Package')
    ->options([
        'popular_pair' => 'Popular Pair - $65',
        'picture_perfect' => 'Picture Perfect - $79',
        'digital_duo' => 'Digital Duo - $55',
        'triple_treat' => 'Triple Treat - $65',
        'fantastic_four' => 'Fantastic Four - $124',
    ])
    ->visible(fn (Get $get) => 
        $get('sibling_special') === 'yes' && 
        $get('number_of_children') == 3
    )
    ->required(fn (Get $get) => 
        $get('sibling_special') === 'yes' && 
        $get('number_of_children') == 3
    ),
```

---

## Rule 5: Has Two Backdrops → Second Package Required

### Trigger
`has_two_backdrops` = true (set from school selection)

### Actions
1. Show info message about second package requirement
2. Show "Select your second Package" field (required)
3. Calculate second package price

### Implementation
```php
Placeholder::make('two_backdrops_notice')
    ->content('⚠️ The second Pack is mandatory since you have selected two backdrops. Learn more about backdrop selection.')
    ->visible(fn (Get $get) => $get('has_two_backdrops') == true),

Radio::make('second_package')
    ->label('Select your second Package *')
    ->options([
        'single_smile' => 'Single Smile - $48',
        'popular_pair' => 'Popular Pair - $65',
        'picture_perfect' => 'Picture Perfect - $79',
        'digital_duo' => 'Digital Duo - $55',
        'triple_treat' => 'Triple Treat - $65',
        'fantastic_four' => 'Fantastic Four - $124',
    ])
    ->visible(fn (Get $get) => $get('has_two_backdrops') == true)
    ->required(fn (Get $get) => $get('has_two_backdrops') == true)
    ->reactive()
    ->afterStateUpdated(function ($state, Set $set) {
        $prices = [
            'single_smile' => 48,
            'popular_pair' => 65,
            'picture_perfect' => 79,
            'digital_duo' => 55,
            'triple_treat' => 65,
            'fantastic_four' => 124,
        ];
        $set('second_package_total', $prices[$state] ?? 0);
    }),

Hidden::make('second_package_total')->default(0),
```

---

## Rule 6: Number of Children → Third Package Option

### Trigger
`number_of_children` = 3

### Actions
Show third package selection field

### Implementation
```php
Radio::make('third_package')
    ->label('Third Pack Selection')
    ->options([
        'single_smile' => 'Single Smile - $48',
        'popular_pair' => 'Popular Pair - $65',
        'picture_perfect' => 'Picture Perfect - $79',
        'digital_duo' => 'Digital Duo - $55',
        'triple_treat' => 'Triple Treat - $65',
        'fantastic_four' => 'Fantastic Four - $124',
    ])
    ->visible(fn (Get $get) => $get('number_of_children') == 3)
    ->reactive()
    ->afterStateUpdated(function ($state, Set $set) {
        $prices = [
            'single_smile' => 48,
            'popular_pair' => 65,
            'picture_perfect' => 79,
            'digital_duo' => 55,
            'triple_treat' => 65,
            'fantastic_four' => 124,
        ];
        $set('third_package_total', $prices[$state] ?? 0);
    }),

Hidden::make('third_package_total')->default(0),
```

---

## Rule 7: Pose Perfection Pricing by Number of Children

### Trigger
User selects Pose Perfection service

### Actions
- 1 child: Show $14 option
- 2 children: Show $28 option
- 3 children: Show $42 option

### Implementation
```php
Radio::make('pose_perfection')
    ->label(function (Get $get) {
        $numChildren = $get('number_of_children') ?? 1;
        $prices = [1 => 14, 2 => 28, 3 => 42];
        $price = $prices[$numChildren];
        
        $labels = [
            1 => "Upgrade to Pose Perfection for Only $$price?",
            2 => "Upgrade to Pose Perfection for both your children for Only $$price?",
            3 => "Upgrade to Pose Perfection for each pack for your three children's pack for Only $$price?",
        ];
        
        return $labels[$numChildren];
    })
    ->options(function (Get $get) {
        $numChildren = $get('number_of_children') ?? 1;
        
        $yesLabels = [
            1 => 'Yes, include the 2 extra poses',
            2 => 'Yes, include the 2 poses extras for each pack',
            3 => 'Yes, include the 2 poses extras for each pack',
        ];
        
        return [
            'yes' => $yesLabels[$numChildren],
            'no' => 'No, Thanks',
        ];
    })
    ->default('no')
    ->reactive()
    ->afterStateUpdated(function ($state, Set $set, Get $get) {
        if ($state === 'yes') {
            $numChildren = $get('number_of_children') ?? 1;
            $prices = [1 => 14, 2 => 28, 3 => 42];
            $set('pose_perfection_total', $prices[$numChildren]);
        } else {
            $set('pose_perfection_total', 0);
        }
    }),

Hidden::make('pose_perfection_total')->default(0),
```

---

## Rule 8: Premium Retouch → Specification Field

### Trigger
User selects "Yes, please" for Premium Retouch

### Actions
Show text field: "Specify what you would like to have retouched?"

### Implementation
```php
Radio::make('premium_retouch')
    ->label('Would you like to include the Premium Retouch Service? $12')
    ->options([
        'yes' => 'Yes, please',
        'no' => 'No, Thanks',
    ])
    ->default('no')
    ->reactive()
    ->afterStateUpdated(function ($state, Set $set) {
        if ($state === 'yes') {
            $set('premium_retouch_total', 12);
        } else {
            $set('premium_retouch_total', 0);
            $set('retouch_specification', null);
        }
    }),

TextInput::make('retouch_specification')
    ->label('Specify what you would like to have retouched?')
    ->visible(fn (Get $get) => $get('premium_retouch') === 'yes'),

Hidden::make('premium_retouch_total')->default(0),
```

---

## Rule 9: Shipping Method → Address Fields & Cost

### Trigger
User selects "Home Shipping"

### Actions
1. Show shipping address fields (all required)
2. Set shipping cost to $7

### Implementation
```php
Radio::make('shipping_method')
    ->label('What type of shipping method would you prefer to have?')
    ->options([
        'school' => 'Free Shipping to the school - 3 to 4 weeks after the session.',
        'home' => 'Home Shipping - 6 to 10 business days after selecting you images - $7',
    ])
    ->default('school')
    ->reactive()
    ->afterStateUpdated(function ($state, Set $set) {
        if ($state === 'home') {
            $set('shipping_total', 7);
        } else {
            $set('shipping_total', 0);
            // Clear address fields
            $set('shipping_address', null);
            $set('shipping_address_line2', null);
            $set('shipping_city', null);
            $set('shipping_state', null);
            $set('shipping_zip', null);
        }
    }),

Section::make('Shipping Address')
    ->schema([
        TextInput::make('shipping_address')
            ->label('Street Address')
            ->required(),
        TextInput::make('shipping_address_line2')
            ->label('Street Address Line 2'),
        TextInput::make('shipping_city')
            ->label('City')
            ->required(),
        Select::make('shipping_state')
            ->label('State')
            ->options([
                'AL' => 'Alabama',
                'FL' => 'Florida',
                // ... all 50 states
            ])
            ->required()
            ->searchable(),
        TextInput::make('shipping_zip')
            ->label('Zip Code')
            ->required()
            ->mask('99999'),
    ])
    ->visible(fn (Get $get) => $get('shipping_method') === 'home'),

Hidden::make('shipping_total')->default(0),
```

---

## Rule 10: Main Package → 4 Poses Digital Upgrade Availability

### Trigger
User selects any main package

### Actions
Show "Upgrade to 4 Poses Digital for $10" option

### Implementation
```php
Radio::make('main_package')
    ->label('Select your child\'s Main Package *')
    ->options([
        'single_smile' => 'Single Smile - $48',
        'popular_pair' => 'Popular Pair - $65',
        'picture_perfect' => 'Picture Perfect - $79',
        'digital_duo' => 'Digital Duo - $55',
        'triple_treat' => 'Triple Treat - $65',
        'fantastic_four' => 'Fantastic Four - $124',
    ])
    ->required()
    ->reactive()
    ->afterStateUpdated(function ($state, Set $set) {
        $prices = [
            'single_smile' => 48,
            'popular_pair' => 65,
            'picture_perfect' => 79,
            'digital_duo' => 55,
            'triple_treat' => 65,
            'fantastic_four' => 124,
        ];
        $set('main_package_total', $prices[$state] ?? 0);
    }),

Radio::make('four_poses_digital_upgrade')
    ->label('Would you like to upgrade to 4 Poses Digital for only $10?')
    ->options([
        'yes' => 'Yes, that would be great!',
        'no' => 'No, thank you',
    ])
    ->default('no')
    ->visible(fn (Get $get) => $get('main_package'))
    ->reactive()
    ->afterStateUpdated(function ($state, Set $set) {
        $set('four_poses_upgrade_total', $state === 'yes' ? 10 : 0);
    }),

Hidden::make('main_package_total')->default(0),
Hidden::make('four_poses_upgrade_total')->default(0),
```

---

## Rule 11: Registration Type → Payment Visibility

### Trigger
User selects registration type

### Actions
- "Prepay and Unlock All Benefits": Show payment section
- "Register without Pre-Paying": Hide payment, submit as registration only

### Implementation
```php
Radio::make('registration_type')
    ->label('Picture Day is Here! How Do You Want to Join?')
    ->options([
        'prepay' => 'Prepay and Unlock All Benefits',
        'register_only' => 'Register without Pre-Paying',
    ])
    ->default('prepay')
    ->reactive()
    ->required(),

// In form wizard or submission logic
public function submit()
{
    $data = $this->form->getState();
    
    if ($data['registration_type'] === 'prepay') {
        // Process payment with Stripe
        // Create order with payment
    } else {
        // Create registration without payment
        // Send different email confirmation
    }
}
```

---

## Testing Checklist

Use this checklist to ensure all conditional logic works:

- [ ] Test all 7 project types for correct backdrop fields
- [ ] Test 1, 2, and 3 children scenarios
- [ ] Test sibling special with different child counts
- [ ] Test two backdrop schools
- [ ] Test all upgrade options
- [ ] Test premium retouch specification field
- [ ] Test home vs school shipping
- [ ] Test pose perfection with 1, 2, 3 children
- [ ] Test 4 poses upgrade availability
- [ ] Test register without prepaying (no payment)
- [ ] Test third package with 3 children
- [ ] Test complex scenario: 3 children + sibling + all upgrades + home shipping

---

## Summary: Conditional Logic Rules

| # | Trigger | Action | Complexity |
|---|---------|--------|------------|
| 1 | School selected | Set project config, deadline, backdrops | High |
| 2 | Project type set | Show specific backdrop field(s) | Medium |
| 3 | Number of children | Show child 2 & 3 fields | Medium |
| 4 | Sibling special | Show sibling package fields | Medium |
| 5 | Two backdrops | Require second package | Medium |
| 6 | Three children | Show third package option | Low |
| 7 | Pose Perfection + children | Adjust price & label | Medium |
| 8 | Premium Retouch | Show specification field | Low |
| 9 | Home shipping | Show address fields, add $7 | Medium |
| 10 | Package selected | Show 4 Poses upgrade | Low |
| 11 | Registration type | Show/hide payment section | Medium |

---

**Next Steps:**
1. Implement these rules in Filament form
2. Create comprehensive feature tests
3. Build pricing calculator using these rules
4. Document edge cases and validation

---

**Document Status:** ✅ Complete  
**Last Updated:** November 1, 2025  
**Version:** 1.0

