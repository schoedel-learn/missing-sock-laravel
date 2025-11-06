# The Missing Sock Photography - Design System

**Version:** 1.0.0  
**Last Updated:** 2025-01-27

---

## 📋 Table of Contents

1. [Overview](#overview)
2. [Design Tokens](#design-tokens)
3. [Typography](#typography)
4. [Colors](#colors)
5. [Components](#components)
6. [Spacing](#spacing)
7. [Layout](#layout)
8. [Usage Guidelines](#usage-guidelines)

---

## Overview

This design system provides a comprehensive set of design tokens, components, and guidelines for building consistent, accessible, and beautiful interfaces for The Missing Sock Photography brand.

### Design Principles

1. **Warmth & Approachability** - Colors and typography create a friendly, family-focused atmosphere
2. **Professionalism** - Clean, modern design maintains credibility
3. **Accessibility** - WCAG AA compliant color contrasts and focus states
4. **Consistency** - Unified components and patterns across all interfaces
5. **Responsiveness** - Mobile-first approach ensuring great experiences on all devices

---

## Design Tokens

### Files Location

- **Tailwind Config:** `tailwind.config.js`
- **CSS Variables:** `resources/css/app.css`
- **PHP Config:** `config/brand.php`

### Usage

```blade
{{-- In Blade templates --}}
<div class="bg-primary text-white">...</div>

{{-- In PHP --}}
config('brand.colors.primary.coral')

{{-- In CSS --}}
background-color: var(--primary-coral);
```

---

## Typography

### Font Families

#### Primary: Nunito (Sans-Serif)
**Usage:** Body text, UI elements, most headings

**Weights:**
- 300 (Light) - Large headings, emphasis
- 400 (Regular) - Body text
- 600 (SemiBold) - Subheadings, UI elements
- 700 (Bold) - Primary headings, CTAs
- 800 (ExtraBold) - Hero headings

#### Secondary: Playfair Display (Serif)
**Usage:** Hero headings, featured text, elegant emphasis

**Weights:**
- 600 (SemiBold) - Featured headings
- 700 (Bold) - Hero text

#### Monospace: Inter
**Usage:** Numbers, pricing, codes, technical information

### Type Scale

| Size | Value | Line Height | Usage |
|------|-------|-------------|-------|
| xs | 0.75rem (12px) | 1rem | Labels, captions |
| sm | 0.875rem (14px) | 1.25rem | Small body text |
| base | 1rem (16px) | 1.6 | Body text |
| lg | 1.125rem (18px) | 1.7 | Large body, lead text |
| xl | 1.25rem (20px) | 1.75rem | H5, emphasized text |
| 2xl | 1.5rem (24px) | 2rem | H4 |
| 3xl | 1.875rem (30px) | 2.25rem | H3 |
| 4xl | 2.25rem (36px) | 2.5rem | H2 |
| 5xl | 3rem (48px) | 1.2 | H1 |
| 6xl | 3.75rem (60px) | 1.1 | Hero headings |
| 7xl | 4.5rem (72px) | 1.1 | Large hero |
| 8xl | 6rem (96px) | 1 | Display headings |

### Heading Hierarchy

```blade
<h1 class="h1">Main Page Title</h1>
<h2 class="h2">Section Heading</h2>
<h3 class="h3">Subsection Heading</h3>
<h4 class="h4">Card Title</h4>
<h5 class="h5">Small Heading</h5>
<h6 class="h6">Tiny Heading</h6>

{{-- Hero Heading with Serif Font --}}
<h1 class="hero-heading">Featured Title</h1>
```

### Responsive Typography

Headings automatically scale on larger screens:

- **Mobile (base):** H1 = 3rem, H2 = 2.25rem
- **Tablet (md):** H1 = 3.75rem, H2 = 2.5rem
- **Desktop (lg):** H1 = 4.5rem, Hero = 5rem

---

## Colors

### Primary Colors

#### Coral Orange (#FF5E3F)
**Usage:** Primary CTAs, key actions, important buttons

**Scale:**
- 50: `#FFF5F3` - Lightest tint
- 100: `#FFE5E0` - Light background
- 500: `#FF5E3F` - **DEFAULT** - Primary color
- 600: `#E84A2F` - Hover state
- 700: `#CC4B32` - Dark variant
- 900: `#85301F` - Darkest shade

**Examples:**
```blade
<button class="bg-primary text-white">Primary Button</button>
<div class="bg-primary-100 text-primary-800">Light Background</div>
```

### Accent Colors

#### Golden Yellow (#F1BF61)
**Usage:** Section backgrounds, footer, accent buttons, secondary CTAs

**Scale:**
- 50: `#FEFBF3` - Lightest tint
- 100: `#F9E8C0` - Light background
- 300: `#F1BF61` - **DEFAULT** - Accent color
- 400: `#E5B04D` - Hover state
- 500: `#C99A4E` - Dark variant

**Examples:**
```blade
<section class="bg-accent-golden text-white">Accent Section</section>
<button class="bg-accent-golden hover:bg-accent-golden-hover">Accent Button</button>
```

### Background Colors

- **Main:** `#ECE9E6` - Soft beige, page background
- **Main Light:** `#F5F3F1` - Lighter variant
- **Main Dark:** `#D9D5D0` - Darker variant
- **White:** `#FFFFFF` - Clean white

### Semantic Colors

#### Success (#27AE60)
Used for success messages, positive actions, confirmations

#### Warning (#F39C12)
Used for warnings, cautionary messages

#### Error (#f23a3c)
Used for errors, destructive actions, validation failures

#### Info (#039dcf)
Used for informational messages, tips

### Neutral Colors (Gray Scale)

| Shade | Value | Usage |
|-------|-------|-------|
| 50 | `#F8F9FA` | Lightest backgrounds |
| 100 | `#F8F9FA` | Light backgrounds |
| 200 | `#ecedf3` | Subtle borders |
| 300 | `#D5DBDB` | Borders, dividers |
| 400 | `#BDC3C7` | Disabled states |
| 500 | `#95A5A6` | Placeholder text |
| 600 | `#8894AB` | Secondary text |
| 700 | `#5A6C7D` | Body text |
| 800 | `#34495E` | Headings |
| 900 | `#2C3E50` | Primary headings |

---

## Components

### Buttons

#### Variants

```blade
{{-- Primary Button --}}
<button class="btn btn-primary">Primary Action</button>

{{-- Secondary Button --}}
<button class="btn btn-secondary">Secondary Action</button>

{{-- Accent Button --}}
<button class="btn btn-accent">Accent Action</button>

{{-- Outline Button --}}
<button class="btn btn-outline">Outline Button</button>

{{-- Ghost Button --}}
<button class="btn btn-ghost">Ghost Button</button>

{{-- Danger Button --}}
<button class="btn btn-danger">Delete</button>

{{-- Success Button --}}
<button class="btn btn-success">Confirm</button>
```

#### Sizes

```blade
<button class="btn btn-primary btn-sm">Small</button>
<button class="btn btn-primary">Default</button>
<button class="btn btn-primary btn-lg">Large</button>
<button class="btn btn-primary btn-xl">Extra Large</button>
```

#### States

```blade
{{-- Disabled --}}
<button class="btn btn-primary" disabled>Disabled</button>

{{-- Loading --}}
<button class="btn btn-primary btn-loading">Loading...</button>
```

### Cards

```blade
{{-- Basic Card --}}
<div class="card">
  <h3>Card Title</h3>
  <p>Card content</p>
</div>

{{-- Card with Hover Effect --}}
<div class="card card-hover">
  <h3>Hoverable Card</h3>
</div>

{{-- Card Variants --}}
<div class="card card-primary">Primary Card</div>
<div class="card card-accent">Accent Card</div>
<div class="card card-success">Success Card</div>

{{-- Card with Header/Footer --}}
<div class="card">
  <div class="card-header">
    <h3>Header</h3>
  </div>
  <p>Content</p>
  <div class="card-footer">
    <button class="btn btn-primary">Action</button>
  </div>
</div>
```

### Form Elements

```blade
{{-- Input Field --}}
<div class="form-group">
  <label class="label label-required">Email</label>
  <input type="email" class="input" placeholder="Enter email">
  <p class="help-text">We'll never share your email</p>
</div>

{{-- Input with Error --}}
<input type="text" class="input error" placeholder="Invalid input">
<p class="help-text error">This field is required</p>

{{-- Input with Success --}}
<input type="text" class="input success" placeholder="Valid input">
<p class="help-text success">Looks good!</p>

{{-- Textarea --}}
<textarea class="textarea" placeholder="Enter message"></textarea>

{{-- Select --}}
<select class="select">
  <option>Choose option</option>
</select>

{{-- Checkbox --}}
<input type="checkbox" class="checkbox" id="agree">
<label for="agree">I agree</label>

{{-- Radio --}}
<input type="radio" class="radio" name="option" id="option1">
<label for="option1">Option 1</label>
```

### Alerts

```blade
{{-- Success Alert --}}
<div class="alert alert-success">
  <p>Operation completed successfully!</p>
</div>

{{-- Warning Alert --}}
<div class="alert alert-warning">
  <p>Please review your information</p>
</div>

{{-- Error Alert --}}
<div class="alert alert-error">
  <p>Something went wrong</p>
</div>

{{-- Info Alert --}}
<div class="alert alert-info">
  <p>Here's some helpful information</p>
</div>
```

### Badges

```blade
<span class="badge badge-primary">New</span>
<span class="badge badge-accent">Featured</span>
<span class="badge badge-success">Active</span>
<span class="badge badge-warning">Pending</span>
<span class="badge badge-error">Inactive</span>
<span class="badge badge-info">Info</span>
<span class="badge badge-gray">Default</span>
```

### Loading States

```blade
{{-- Spinner --}}
<div class="spinner"></div>
<div class="spinner spinner-sm"></div>
<div class="spinner spinner-lg"></div>

{{-- Skeleton Loading --}}
<div class="skeleton-text mb-2"></div>
<div class="skeleton-text mb-2 w-3/4"></div>
<div class="skeleton-avatar"></div>
<div class="skeleton-button w-32"></div>
```

### Dividers

```blade
{{-- Horizontal Divider --}}
<div class="divider"></div>

{{-- Vertical Divider --}}
<div class="divider-vertical"></div>
```

---

## Spacing

### Scale

Based on Tailwind's spacing scale (4px base unit):

- `0` = 0px
- `1` = 0.25rem (4px)
- `2` = 0.5rem (8px)
- `4` = 1rem (16px)
- `6` = 1.5rem (24px)
- `8` = 2rem (32px)
- `12` = 3rem (48px)
- `16` = 4rem (64px)
- `20` = 5rem (80px)
- `24` = 6rem (96px)

### Custom Spacing

- `18` = 4.5rem (72px)
- `88` = 22rem (352px)
- `128` = 32rem (512px)

---

## Layout

### Container

```blade
<div class="container-custom">
  <!-- Content max-width: 1280px -->
</div>
```

### Sections

```blade
<section class="section">
  <!-- py-12 md:py-16 lg:py-20 -->
</section>
```

### Grid System

Uses Tailwind's grid system:

```blade
{{-- 2 Column Grid --}}
<div class="grid grid-cols-1 md:grid-cols-2 gap-8">
  <div>Column 1</div>
  <div>Column 2</div>
</div>

{{-- 3 Column Grid --}}
<div class="grid grid-cols-1 md:grid-cols-3 gap-8">
  <div>Column 1</div>
  <div>Column 2</div>
  <div>Column 3</div>
</div>
```

---

## Usage Guidelines

### Color Usage

1. **Primary Actions:** Always use coral orange (#FF5E3F) for primary CTAs
2. **Secondary Actions:** Use golden yellow (#F1BF61) or white buttons with colored text
3. **Backgrounds:** Use soft beige (#ECE9E6) for main backgrounds, white for cards
4. **Text:** Use gray-800 for body text, gray-900 for headings
5. **Contrast:** Ensure WCAG AA compliance (4.5:1 for normal text, 3:1 for large text)

### Typography Usage

1. **Headings:** Use appropriate heading level (h1-h6) based on hierarchy
2. **Body Text:** Use base size (16px) with 1.6 line height
3. **Hero Text:** Use `hero-heading` class for featured headings
4. **Responsive:** Let responsive typography handle scaling automatically

### Component Usage

1. **Consistency:** Always use predefined component classes
2. **Accessibility:** Include proper labels, ARIA attributes, focus states
3. **States:** Handle hover, focus, active, and disabled states
4. **Spacing:** Use consistent spacing scale throughout

### Best Practices

1. **Mobile First:** Design for mobile, enhance for desktop
2. **Performance:** Minimize custom CSS, leverage Tailwind utilities
3. **Accessibility:** Test with keyboard navigation and screen readers
4. **Consistency:** Follow established patterns and conventions
5. **Documentation:** Document custom components and patterns

---

## File Structure

```
resources/
├── css/
│   └── app.css          # Main stylesheet with components
├── views/
│   ├── components/      # Reusable Blade components
│   └── layouts/         # Layout templates
└── js/
    └── app.js           # JavaScript

config/
└── brand.php            # Brand configuration

tailwind.config.js       # Tailwind configuration
```

---

## Resources

- [Tailwind CSS Documentation](https://tailwindcss.com/docs)
- [WCAG Guidelines](https://www.w3.org/WAI/WCAG21/quickref/)
- [Design Tokens Guide](https://www.designtokens.org/)

---

**Maintained by:** Development Team  
**Questions?** Contact the development team

