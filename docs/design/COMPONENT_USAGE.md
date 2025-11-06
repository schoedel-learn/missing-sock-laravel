# Component Usage Guide

This guide shows how to use the Blade component templates available in `resources/views/components/ui/`.

---

## Buttons

### Basic Usage

```blade
{{-- Primary Button --}}
<x-ui.button>Click Me</x-ui.button>

{{-- With Variant --}}
<x-ui.button variant="secondary">Secondary</x-ui.button>
<x-ui.button variant="accent">Accent</x-ui.button>
<x-ui.button variant="outline">Outline</x-ui.button>
<x-ui.button variant="ghost">Ghost</x-ui.button>
<x-ui.button variant="danger">Delete</x-ui.button>
<x-ui.button variant="success">Confirm</x-ui.button>

{{-- With Size --}}
<x-ui.button size="sm">Small</x-ui.button>
<x-ui.button size="lg">Large</x-ui.button>
<x-ui.button size="xl">Extra Large</x-ui.button>

{{-- As Link --}}
<x-ui.button href="/page" variant="primary">Go to Page</x-ui.button>

{{-- With Attributes --}}
<x-ui.button 
    variant="primary" 
    size="lg"
    type="submit"
    class="w-full"
>
    Submit Form
</x-ui.button>

{{-- Loading State --}}
<x-ui.button loading>Processing...</x-ui.button>

{{-- Disabled --}}
<x-ui.button disabled>Disabled</x-ui.button>
```

---

## Cards

### Basic Usage

```blade
{{-- Simple Card --}}
<x-ui.card>
    <h3>Card Title</h3>
    <p>Card content goes here</p>
</x-ui.card>

{{-- Card with Hover Effect --}}
<x-ui.card hover>
    <h3>Hoverable Card</h3>
    <p>This card lifts on hover</p>
</x-ui.card>

{{-- Card Variants --}}
<x-ui.card variant="primary">
    <h3>Primary Card</h3>
</x-ui.card>

<x-ui.card variant="accent">
    <h3>Accent Card</h3>
</x-ui.card>

{{-- Card with Header/Footer --}}
<x-ui.card>
    <div class="card-header">
        <h3>Card Header</h3>
    </div>
    <p>Card body content</p>
    <div class="card-footer">
        <x-ui.button variant="primary">Action</x-ui.button>
    </div>
</x-ui.card>
```

---

## Alerts

### Basic Usage

```blade
{{-- Success Alert --}}
<x-ui.alert type="success">
    Operation completed successfully!
</x-ui.alert>

{{-- Warning Alert --}}
<x-ui.alert type="warning">
    Please review your information
</x-ui.alert>

{{-- Error Alert --}}
<x-ui.alert type="error">
    Something went wrong
</x-ui.alert>

{{-- Info Alert --}}
<x-ui.alert type="info">
    Here's some helpful information
</x-ui.alert>

{{-- Dismissible Alert --}}
<x-ui.alert type="success" dismissible>
    This alert can be dismissed
</x-ui.alert>

{{-- Without Icon --}}
<x-ui.alert type="info" :icon="false">
    No icon version
</x-ui.alert>
```

---

## Badges

### Basic Usage

```blade
{{-- Badge Variants --}}
<x-ui.badge variant="primary">New</x-ui.badge>
<x-ui.badge variant="accent">Featured</x-ui.badge>
<x-ui.badge variant="success">Active</x-ui.badge>
<x-ui.badge variant="warning">Pending</x-ui.badge>
<x-ui.badge variant="error">Inactive</x-ui.badge>
<x-ui.badge variant="info">Info</x-ui.badge>
<x-ui.badge variant="gray">Default</x-ui.badge>
```

---

## Form Inputs

### Text Input

```blade
<x-ui.input 
    name="email"
    label="Email Address"
    type="email"
    placeholder="Enter your email"
    required
    help="We'll never share your email"
/>

{{-- With Error --}}
<x-ui.input 
    name="username"
    label="Username"
    error="This username is already taken"
/>

{{-- With Success --}}
<x-ui.input 
    name="email"
    label="Email"
    success="Email is available"
/>
```

### Textarea

```blade
<x-ui.textarea 
    name="message"
    label="Message"
    rows="5"
    placeholder="Enter your message"
    required
>
</x-ui.textarea>
```

### Select

```blade
<x-ui.select 
    name="country"
    label="Country"
    :options="[
        'us' => 'United States',
        'ca' => 'Canada',
        'uk' => 'United Kingdom'
    ]"
    placeholder="Select a country"
    required
/>
```

---

## Modals

### Basic Usage

```blade
{{-- Simple Modal --}}
<x-ui.modal id="example-modal" title="Example Modal">
    <p>Modal content goes here</p>
    
    <x-slot name="footer">
        <x-ui.button variant="ghost" onclick="document.getElementById('example-modal').classList.remove('show')">
            Cancel
        </x-ui.button>
        <x-ui.button variant="primary">Confirm</x-ui.button>
    </x-slot>
</x-ui.modal>

{{-- Trigger Button --}}
<x-ui.button onclick="document.getElementById('example-modal').classList.add('show'); document.getElementById('example-modal-backdrop').classList.add('show');">
    Open Modal
</x-ui.button>

{{-- Large Modal --}}
<x-ui.modal id="large-modal" title="Large Modal" size="lg">
    <p>Large modal content</p>
</x-ui.modal>
```

---

## Progress Bars

### Basic Usage

```blade
{{-- Basic Progress --}}
<x-ui.progress :value="75" />

{{-- With Label --}}
<x-ui.progress :value="50" show-label />

{{-- Custom Label --}}
<x-ui.progress :value="30" label="30% Complete" />

{{-- Variants --}}
<x-ui.progress :value="80" variant="success" />
<x-ui.progress :value="60" variant="warning" />
<x-ui.progress :value="40" variant="error" />
```

---

## Tabs

### Basic Usage

```blade
<x-ui.tabs 
    id="my-tabs"
    :tabs="['Tab 1', 'Tab 2', 'Tab 3']"
    :active-tab="0"
>
    <div>Content for Tab 1</div>
    <div>Content for Tab 2</div>
    <div>Content for Tab 3</div>
</x-ui.tabs>

{{-- With Array Configuration --}}
<x-ui.tabs 
    id="advanced-tabs"
    :tabs="[
        ['name' => 'Profile', 'content' => '<p>Profile content</p>'],
        ['name' => 'Settings', 'content' => '<p>Settings content</p>'],
    ]"
/>
```

---

## Accordion

### Basic Usage

```blade
<x-ui.accordion 
    id="faq-accordion"
    :items="[
        ['title' => 'Question 1', 'content' => '<p>Answer 1</p>'],
        ['title' => 'Question 2', 'content' => '<p>Answer 2</p>', 'open' => true],
        ['title' => 'Question 3', 'content' => '<p>Answer 3</p>'],
    ]"
    :allow-multiple="false"
/>
```

---

## Empty States

### Basic Usage

```blade
{{-- Simple Empty State --}}
<x-ui.empty-state 
    title="No items found"
    description="There are no items to display at this time."
/>

{{-- With Custom Icon --}}
<x-ui.empty-state 
    title="No Results"
    description="Try adjusting your search criteria."
>
    <x-slot name="icon">
        <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
        </svg>
    </x-slot>
    
    <x-ui.button variant="primary">Create New Item</x-ui.button>
</x-ui.empty-state>
```

---

## Breadcrumbs

### Basic Usage

```blade
<x-ui.breadcrumb 
    :items="[
        ['label' => 'Home', 'url' => '/'],
        ['label' => 'Products', 'url' => '/products'],
        ['label' => 'Current Page'],
    ]"
/>
```

---

## Pagination

### Basic Usage

```blade
{{-- With Laravel Paginator --}}
<x-ui.pagination :paginator="$items" />

{{-- Custom Styling --}}
<x-ui.pagination 
    :paginator="$items" 
    class="justify-center mt-8"
/>
```

---

## Component Combinations

### Form Example

```blade
<x-ui.card>
    <div class="card-header">
        <h3>Contact Form</h3>
    </div>
    
    <form>
        <x-ui.input 
            name="name"
            label="Full Name"
            required
        />
        
        <x-ui.input 
            name="email"
            label="Email"
            type="email"
            required
        />
        
        <x-ui.textarea 
            name="message"
            label="Message"
            rows="5"
            required
        />
        
        <div class="card-footer">
            <x-ui.button variant="ghost" type="button">Cancel</x-ui.button>
            <x-ui.button variant="primary" type="submit">Submit</x-ui.button>
        </div>
    </form>
</x-ui.card>
```

### Card Grid Example

```blade
<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    @foreach($items as $item)
        <x-ui.card hover variant="primary">
            <h4>{{ $item->title }}</h4>
            <p>{{ $item->description }}</p>
            <x-ui.button variant="outline" size="sm">Learn More</x-ui.button>
        </x-ui.card>
    @endforeach
</div>
```

---

## Tips

1. **Always provide accessible labels** for form inputs
2. **Use semantic HTML** - components output proper ARIA attributes
3. **Combine components** for complex UIs
4. **Override styles** using the `class` attribute when needed
5. **Use slots** for flexible content areas (like modal footer)

---

## Customization

All components accept standard HTML attributes via `$attributes`, so you can:

```blade
{{-- Add custom classes --}}
<x-ui.button variant="primary" class="w-full md:w-auto">

{{-- Add data attributes --}}
<x-ui.card data-id="{{ $item->id }}">

{{-- Add event handlers --}}
<x-ui.button onclick="handleClick()">
```

---

For more examples, see the component source files in `resources/views/components/ui/`.

