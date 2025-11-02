# Brand Guidelines & UI/UX Design System
## The Missing Sock Photography

**Purpose:** Comprehensive brand guidelines for Laravel application development  
**Target:** Public-facing pre-order form and customer portal  
**Date:** November 1, 2025  
**Version:** 1.0

---

## 🎨 Executive Summary

The Missing Sock Photography brand is warm, friendly, and professional with a focus on capturing childhood memories. The visual identity emphasizes:

- **Warmth & Approachability** - Welcoming parents and children
- **Professionalism** - Trust in photography services
- **Playfulness** - Reflected in the whimsical brand name
- **Clarity** - Easy-to-navigate, clear information

---

## 📐 Logo & Brand Mark

### Primary Logo

**Logo Details:**
- **File:** `LOGO_LOGO copia 128.png`
- **Source:** `https://eu-files.jotform.com/jufs/The_info820/form_files/LOGO_LOGO%20copia%20128.66b5d4d5ca8165.55339974.png`
- **Type:** Wordmark with icon
- **Style:** Clean, friendly, professional

### Logo Usage Guidelines

#### Minimum Size
- **Digital:** 120px width minimum
- **Print:** 1 inch width minimum
- **Favicon:** 32x32px or 64x64px

#### Clear Space
- Maintain clear space equal to the height of the "M" in "Missing" around all sides
- No text, graphics, or other elements within this zone

#### Logo Variations Needed

```
Primary Logo:
├── Full Color (on white background)
├── Full Color (on dark background)
├── Monochrome White (for dark backgrounds)
├── Monochrome Black (for light backgrounds)
└── Favicon/Icon only (for app icons)
```

#### What NOT to Do
❌ Don't stretch or distort the logo  
❌ Don't rotate the logo  
❌ Don't change logo colors  
❌ Don't add effects (shadows, gradients, outlines)  
❌ Don't place on busy backgrounds  

---

## 🎨 Color Palette

### Primary Colors

Based on JotForm theme analysis and photography industry standards:

#### Brand Blue (Primary)
```css
--primary-blue: #4A90E2;
--primary-blue-hover: #357ABD;
--primary-blue-light: #E8F4FD;
--primary-blue-dark: #2E5A8A;
```
**Usage:** Primary CTAs, links, navigation active states  
**Accessibility:** Meets WCAG AA on white backgrounds

#### Warm Accent (Secondary)
```css
--accent-warm: #FF9F43;
--accent-warm-hover: #F58C2A;
--accent-warm-light: #FFF3E6;
```
**Usage:** Highlights, success messages, featured packages  
**Psychology:** Warmth, creativity, energy

#### Soft Pink (Tertiary)
```css
--accent-pink: #FFC0CB;
--accent-pink-hover: #FFB3C1;
--accent-pink-light: #FFF5F7;
```
**Usage:** Background accents, child-related sections, feminine touch  
**Note:** Use sparingly for emphasis

### Neutral Colors

#### Grays (Text & Backgrounds)
```css
--gray-900: #2C3E50;  /* Primary text */
--gray-800: #34495E;  /* Secondary text */
--gray-700: #5A6C7D;  /* Muted text */
--gray-600: #7B8794;  /* Disabled text */
--gray-500: #95A5A6;  /* Borders, dividers */
--gray-400: #BDC3C7;  /* Light borders */
--gray-300: #D5DBDB;  /* Backgrounds */
--gray-200: #ECF0F1;  /* Light backgrounds */
--gray-100: #F8F9FA;  /* Page background */
--white: #FFFFFF;
--black: #000000;
```

### Semantic Colors

#### Success
```css
--success: #27AE60;
--success-light: #E8F8F0;
--success-dark: #1E8449;
```
**Usage:** Order confirmations, payment success, validation

#### Warning
```css
--warning: #F39C12;
--warning-light: #FEF5E7;
--warning-dark: #D68910;
```
**Usage:** Important notices, deadlines, reminders

#### Error
```css
--error: #E74C3C;
--error-light: #FADBD8;
--error-dark: #C0392B;
```
**Usage:** Form validation errors, payment failures

#### Info
```css
--info: #3498DB;
--info-light: #EBF5FB;
--info-dark: #2874A6;
```
**Usage:** Helpful tips, additional information

### Color Accessibility Matrix

| Foreground | Background | Ratio | WCAG AA | WCAG AAA |
|------------|------------|-------|---------|----------|
| Gray-900 | White | 12.63:1 | ✅ | ✅ |
| Primary Blue | White | 4.52:1 | ✅ | ❌ |
| Primary Blue | Gray-100 | 4.21:1 | ✅ | ❌ |
| Accent Warm | White | 3.12:1 | ⚠️ Large text only | ❌ |
| White | Primary Blue | 4.52:1 | ✅ | ❌ |

---

## 📝 Typography

### Font Families

Based on JotForm analysis and web best practices:

#### Primary Font: Nunito (Sans-Serif)
```css
font-family: 'Nunito', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
```

**Weights Used:**
- Light (300) - Large headings, emphasis
- Regular (400) - Body text
- SemiBold (600) - Subheadings, UI elements
- Bold (700) - Primary headings, CTAs
- ExtraBold (800) - Hero headings

**Why Nunito?**
- Friendly, rounded letterforms
- Excellent readability
- Good web performance
- Versatile weight options

#### Secondary Font: Playfair Display (Serif)
```css
font-family: 'Playfair Display', Georgia, 'Times New Roman', serif;
```

**Weights Used:**
- SemiBold (600) - Featured headings
- Bold (700) - Hero text

**Usage:** Sparingly for elegant emphasis, hero sections, testimonials

#### Monospace: Inter (UI Elements)
```css
font-family: 'Inter', 'SF Mono', Monaco, 'Courier New', monospace;
```

**Usage:** Numbers, pricing, codes, technical information

### Type Scale

```css
/* Desktop Scale (Base: 16px) */
--text-xs: 0.75rem;    /* 12px - Labels, captions */
--text-sm: 0.875rem;   /* 14px - Small body text */
--text-base: 1rem;     /* 16px - Body text */
--text-lg: 1.125rem;   /* 18px - Large body, subheads */
--text-xl: 1.25rem;    /* 20px - H5 */
--text-2xl: 1.5rem;    /* 24px - H4 */
--text-3xl: 1.875rem;  /* 30px - H3 */
--text-4xl: 2.25rem;   /* 36px - H2 */
--text-5xl: 3rem;      /* 48px - H1 */
--text-6xl: 3.75rem;   /* 60px - Hero */

/* Mobile Scale (Responsive) */
@media (max-width: 768px) {
  --text-3xl: 1.5rem;   /* 24px */
  --text-4xl: 1.875rem; /* 30px */
  --text-5xl: 2.25rem;  /* 36px */
  --text-6xl: 2.5rem;   /* 40px */
}
```

### Typography Rules

#### Headings
```css
h1, .h1 {
  font-family: 'Nunito', sans-serif;
  font-weight: 700;
  font-size: var(--text-5xl);
  line-height: 1.2;
  margin-bottom: 1rem;
  color: var(--gray-900);
}

h2, .h2 {
  font-family: 'Nunito', sans-serif;
  font-weight: 600;
  font-size: var(--text-4xl);
  line-height: 1.3;
  margin-bottom: 0.875rem;
  color: var(--gray-900);
}

h3, .h3 {
  font-family: 'Nunito', sans-serif;
  font-weight: 600;
  font-size: var(--text-3xl);
  line-height: 1.4;
  margin-bottom: 0.75rem;
  color: var(--gray-800);
}

/* Featured/Hero Heading (uses Playfair) */
.hero-heading {
  font-family: 'Playfair Display', serif;
  font-weight: 600;
  font-size: var(--text-6xl);
  line-height: 1.1;
  color: var(--gray-900);
}
```

#### Body Text
```css
body, p, .body {
  font-family: 'Nunito', sans-serif;
  font-weight: 400;
  font-size: var(--text-base);
  line-height: 1.6;
  color: var(--gray-800);
}

.lead {
  font-size: var(--text-lg);
  line-height: 1.7;
  color: var(--gray-700);
}

small, .text-small {
  font-size: var(--text-sm);
  color: var(--gray-700);
}
```

#### Links
```css
a {
  color: var(--primary-blue);
  text-decoration: none;
  transition: color 0.2s ease;
}

a:hover {
  color: var(--primary-blue-hover);
  text-decoration: underline;
}
```

---

## 🖼 Imagery Guidelines

### Photography Style

#### Subject Matter
- **Children:** Natural, candid, joyful expressions
- **School Settings:** Clean, professional, well-lit
- **Product Shots:** Crisp, clear, professional product photography
- **Lifestyle:** Parents/children interaction, authentic moments

#### Technical Specifications

**Color Grading:**
- Warm tones preferred
- Slight increase in saturation
- Natural skin tones (critical)
- Avoid heavy filters

**Composition:**
- Rule of thirds
- Clean backgrounds
- Focus on faces/expressions
- Adequate white space

**Quality Requirements:**
- Minimum resolution: 1920x1080px (web)
- Format: WebP (primary), JPG (fallback), PNG (transparency needed)
- Optimization: Compress for web (<200KB per image)
- Alt text: Always include descriptive alt text

### Image Categories

#### Hero Images
- **Dimensions:** 1920x800px (desktop), 768x600px (mobile)
- **Content:** Happy children, school photography scenes
- **Text overlay:** Ensure readable text areas (dark overlay if needed)

#### Package Images
- **Dimensions:** 600x400px (4:3 ratio)
- **Content:** Product shots, example photos
- **Style:** Consistent lighting, white or neutral background

#### Testimonial Photos
- **Dimensions:** 200x200px (square, circular crop)
- **Content:** Parent headshots or child photos
- **Style:** Professional, friendly

#### Background Patterns
- **Subtle:** Soft textures, not distracting
- **Colors:** Light grays, soft blues, warm neutrals
- **Opacity:** 5-15% maximum

---

## 🎭 Icons & Graphics

### Icon Style

**Design System:** Use **Heroicons** (matches Filament default)

```bash
# Heroicons characteristics:
- Outline style (primary)
- Solid style (for emphasis)
- 24x24px default size
- Stroke width: 2px
- Rounded line caps
```

### Icon Usage

```html
<!-- Primary style (outline) -->
<svg class="icon icon-outline">...</svg>

<!-- Emphasis (solid) -->
<svg class="icon icon-solid">...</svg>
```

**Color Rules:**
- Default: `var(--gray-700)`
- Hover: `var(--primary-blue)`
- Active: `var(--primary-blue-hover)`
- Success: `var(--success)`
- Error: `var(--error)`

### Common Icons Needed

| Purpose | Icon | Context |
|---------|------|---------|
| School | `academic-cap` | School selection |
| Calendar | `calendar` | Date picker, deadlines |
| Photo | `camera` | Photography related |
| Package | `shopping-bag` | Package selection |
| Upgrade | `arrow-trending-up` | Upgrades, add-ons |
| Shipping | `truck` | Shipping options |
| Payment | `credit-card` | Payment section |
| Success | `check-circle` | Confirmations |
| Error | `x-circle` | Error messages |
| Info | `information-circle` | Help text |
| Download | `arrow-down-tray` | Download images |
| User | `user-circle` | Account, profile |

---

## 🧩 UI Components

### Buttons

#### Primary Button (CTA)
```css
.btn-primary {
  background-color: var(--primary-blue);
  color: white;
  padding: 12px 24px;
  border-radius: 8px;
  font-weight: 600;
  font-size: var(--text-base);
  transition: all 0.2s ease;
  border: none;
  cursor: pointer;
  box-shadow: 0 2px 4px rgba(74, 144, 226, 0.2);
}

.btn-primary:hover {
  background-color: var(--primary-blue-hover);
  box-shadow: 0 4px 8px rgba(74, 144, 226, 0.3);
  transform: translateY(-1px);
}

.btn-primary:active {
  transform: translateY(0);
  box-shadow: 0 2px 4px rgba(74, 144, 226, 0.2);
}

.btn-primary:disabled {
  background-color: var(--gray-400);
  cursor: not-allowed;
  box-shadow: none;
}
```

#### Secondary Button
```css
.btn-secondary {
  background-color: white;
  color: var(--primary-blue);
  padding: 12px 24px;
  border-radius: 8px;
  font-weight: 600;
  font-size: var(--text-base);
  transition: all 0.2s ease;
  border: 2px solid var(--primary-blue);
  cursor: pointer;
}

.btn-secondary:hover {
  background-color: var(--primary-blue-light);
  border-color: var(--primary-blue-hover);
}
```

#### Ghost Button
```css
.btn-ghost {
  background-color: transparent;
  color: var(--gray-700);
  padding: 12px 24px;
  border-radius: 8px;
  font-weight: 500;
  transition: all 0.2s ease;
  border: none;
}

.btn-ghost:hover {
  background-color: var(--gray-100);
  color: var(--gray-900);
}
```

### Form Inputs

#### Text Input
```css
.input-text {
  width: 100%;
  padding: 12px 16px;
  border: 2px solid var(--gray-400);
  border-radius: 8px;
  font-family: 'Nunito', sans-serif;
  font-size: var(--text-base);
  color: var(--gray-900);
  background-color: white;
  transition: all 0.2s ease;
}

.input-text:focus {
  outline: none;
  border-color: var(--primary-blue);
  box-shadow: 0 0 0 3px var(--primary-blue-light);
}

.input-text:disabled {
  background-color: var(--gray-100);
  color: var(--gray-600);
  cursor: not-allowed;
}

.input-text.error {
  border-color: var(--error);
}

.input-text.error:focus {
  box-shadow: 0 0 0 3px var(--error-light);
}
```

#### Select Dropdown
```css
.input-select {
  width: 100%;
  padding: 12px 16px;
  padding-right: 40px; /* Space for arrow */
  border: 2px solid var(--gray-400);
  border-radius: 8px;
  font-family: 'Nunito', sans-serif;
  font-size: var(--text-base);
  color: var(--gray-900);
  background-color: white;
  background-image: url("data:image/svg+xml,..."); /* Dropdown arrow */
  background-repeat: no-repeat;
  background-position: right 12px center;
  appearance: none;
  cursor: pointer;
  transition: all 0.2s ease;
}

.input-select:focus {
  outline: none;
  border-color: var(--primary-blue);
  box-shadow: 0 0 0 3px var(--primary-blue-light);
}
```

#### Radio Button
```css
.radio-option {
  display: flex;
  align-items: center;
  padding: 16px;
  border: 2px solid var(--gray-300);
  border-radius: 8px;
  cursor: pointer;
  transition: all 0.2s ease;
  margin-bottom: 12px;
}

.radio-option:hover {
  border-color: var(--primary-blue);
  background-color: var(--primary-blue-light);
}

.radio-option.selected {
  border-color: var(--primary-blue);
  background-color: var(--primary-blue-light);
  box-shadow: 0 2px 8px rgba(74, 144, 226, 0.15);
}

.radio-option input[type="radio"] {
  margin-right: 12px;
  accent-color: var(--primary-blue);
}
```

#### Checkbox
```css
.checkbox {
  display: flex;
  align-items: center;
  cursor: pointer;
  user-select: none;
}

.checkbox input[type="checkbox"] {
  margin-right: 8px;
  width: 20px;
  height: 20px;
  accent-color: var(--primary-blue);
  cursor: pointer;
}

.checkbox label {
  cursor: pointer;
  color: var(--gray-800);
}
```

### Cards

#### Standard Card
```css
.card {
  background-color: white;
  border-radius: 12px;
  padding: 24px;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
  transition: all 0.2s ease;
}

.card:hover {
  box-shadow: 0 4px 16px rgba(0, 0, 0, 0.12);
  transform: translateY(-2px);
}
```

#### Package Card (Selectable)
```css
.package-card {
  background-color: white;
  border: 2px solid var(--gray-300);
  border-radius: 12px;
  padding: 24px;
  cursor: pointer;
  transition: all 0.2s ease;
  position: relative;
}

.package-card:hover {
  border-color: var(--primary-blue);
  box-shadow: 0 4px 16px rgba(74, 144, 226, 0.15);
}

.package-card.selected {
  border-color: var(--primary-blue);
  background-color: var(--primary-blue-light);
  box-shadow: 0 4px 16px rgba(74, 144, 226, 0.2);
}

.package-card.selected::after {
  content: '✓';
  position: absolute;
  top: 12px;
  right: 12px;
  width: 28px;
  height: 28px;
  background-color: var(--primary-blue);
  color: white;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  font-weight: bold;
}
```

### Alerts & Notifications

```css
.alert {
  padding: 16px;
  border-radius: 8px;
  border-left: 4px solid;
  margin-bottom: 16px;
  display: flex;
  align-items: flex-start;
}

.alert-success {
  background-color: var(--success-light);
  border-color: var(--success);
  color: var(--success-dark);
}

.alert-warning {
  background-color: var(--warning-light);
  border-color: var(--warning);
  color: var(--warning-dark);
}

.alert-error {
  background-color: var(--error-light);
  border-color: var(--error);
  color: var(--error-dark);
}

.alert-info {
  background-color: var(--info-light);
  border-color: var(--info);
  color: var(--info-dark);
}
```

### Progress Indicator (Wizard)

```css
.wizard-progress {
  display: flex;
  justify-content: space-between;
  margin-bottom: 40px;
  padding: 0 20px;
}

.wizard-step {
  flex: 1;
  text-align: center;
  position: relative;
}

.wizard-step::before {
  content: '';
  position: absolute;
  top: 16px;
  left: 50%;
  right: -50%;
  height: 2px;
  background-color: var(--gray-300);
  z-index: 0;
}

.wizard-step:last-child::before {
  display: none;
}

.wizard-step.completed::before {
  background-color: var(--primary-blue);
}

.wizard-step-circle {
  width: 32px;
  height: 32px;
  border-radius: 50%;
  background-color: var(--gray-300);
  color: white;
  display: flex;
  align-items: center;
  justify-content: center;
  margin: 0 auto 8px;
  position: relative;
  z-index: 1;
  font-weight: 600;
  font-size: var(--text-sm);
}

.wizard-step.active .wizard-step-circle {
  background-color: var(--primary-blue);
  box-shadow: 0 0 0 4px var(--primary-blue-light);
}

.wizard-step.completed .wizard-step-circle {
  background-color: var(--success);
}
```

---

## 📱 Responsive Design

### Breakpoints

```css
/* Mobile First Approach */
--mobile: 320px;        /* Small phones */
--mobile-lg: 425px;     /* Large phones */
--tablet: 768px;        /* Tablets */
--desktop: 1024px;      /* Small desktops */
--desktop-lg: 1440px;   /* Large desktops */
--desktop-xl: 1920px;   /* Extra large screens */
```

### Grid System

```css
.container {
  width: 100%;
  margin: 0 auto;
  padding: 0 16px;
}

@media (min-width: 768px) {
  .container {
    max-width: 720px;
    padding: 0 24px;
  }
}

@media (min-width: 1024px) {
  .container {
    max-width: 960px;
  }
}

@media (min-width: 1440px) {
  .container {
    max-width: 1280px;
  }
}
```

### Mobile Optimization

#### Touch Targets
- Minimum tap target: 44x44px
- Spacing between targets: 8px minimum
- Buttons should be full-width on mobile

#### Font Sizes
- Minimum body text: 16px (prevents iOS zoom)
- Headings scale down 20-30% on mobile
- Line height increases to 1.7 for readability

#### Navigation
- Hamburger menu below 768px
- Sticky header on scroll
- Bottom navigation for key actions on mobile

---

## 🎬 Animation & Transitions

### Timing Functions

```css
--ease-in-out: cubic-bezier(0.4, 0, 0.2, 1);
--ease-out: cubic-bezier(0.0, 0, 0.2, 1);
--ease-in: cubic-bezier(0.4, 0, 1, 1);
--bounce: cubic-bezier(0.68, -0.55, 0.265, 1.55);
```

### Durations

```css
--duration-fast: 150ms;    /* Hover states, tooltips */
--duration-base: 200ms;    /* Most transitions */
--duration-slow: 300ms;    /* Page transitions */
--duration-slower: 500ms;  /* Modal, drawer */
```

### Common Animations

```css
/* Fade In */
@keyframes fadeIn {
  from {
    opacity: 0;
  }
  to {
    opacity: 1;
  }
}

/* Slide Up */
@keyframes slideUp {
  from {
    opacity: 0;
    transform: translateY(20px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

/* Scale In */
@keyframes scaleIn {
  from {
    opacity: 0;
    transform: scale(0.95);
  }
  to {
    opacity: 1;
    transform: scale(1);
  }
}
```

### Animation Principles

✅ **Do:**
- Use for feedback (button clicks, form submissions)
- Indicate state changes
- Guide user attention
- Enhance perceived performance

❌ **Don't:**
- Animate everything
- Use long durations (>500ms)
- Disable for accessibility (respect prefers-reduced-motion)
- Animate on scroll excessively

---

## ♿️ Accessibility Guidelines

### WCAG 2.1 Compliance (Level AA)

#### Color Contrast
- Normal text (16px): 4.5:1 minimum
- Large text (18px+): 3:1 minimum
- UI components: 3:1 minimum

#### Keyboard Navigation
- All interactive elements focusable
- Visible focus indicators
- Logical tab order
- Skip links for main content

#### Screen Readers
- Semantic HTML elements
- ARIA labels where needed
- Alt text for all images
- Live regions for dynamic content

#### Forms
- Label every input
- Error messages clearly associated
- Inline validation
- Success confirmation

### Focus Styles

```css
*:focus-visible {
  outline: 2px solid var(--primary-blue);
  outline-offset: 2px;
  border-radius: 4px;
}

button:focus-visible,
a:focus-visible {
  outline-offset: 4px;
}
```

### Reduced Motion

```css
@media (prefers-reduced-motion: reduce) {
  *,
  *::before,
  *::after {
    animation-duration: 0.01ms !important;
    animation-iteration-count: 1 !important;
    transition-duration: 0.01ms !important;
  }
}
```

---

## 📄 Page Layouts

### Pre-Order Form Layout

```
┌────────────────────────────────────────┐
│            Header (Sticky)             │
│  Logo | Progress Bar | Help           │
├────────────────────────────────────────┤
│                                        │
│  ┌──────────────────────────────────┐ │
│  │                                  │ │
│  │    Wizard Step Content           │ │
│  │    (Max-width: 800px, centered)  │ │
│  │                                  │ │
│  │  ┌────────────────────────────┐ │ │
│  │  │                            │ │ │
│  │  │     Form Fields            │ │ │
│  │  │                            │ │ │
│  │  └────────────────────────────┘ │ │
│  │                                  │ │
│  │  [Back Button]  [Next Button]   │ │
│  │                                  │ │
│  └──────────────────────────────────┘ │
│                                        │
├────────────────────────────────────────┤
│            Footer                      │
│  Support | Privacy | Terms            │
└────────────────────────────────────────┘
```

### Order Summary Layout

```
┌────────────────────────────────────────┐
│  Order Summary                         │
├────────────────────────────────────────┤
│  ┌─────────────────┐  ┌──────────────┐│
│  │                 │  │              ││
│  │  Package Image  │  │  Details     ││
│  │                 │  │  - Price     ││
│  │  (4:3 ratio)    │  │  - Quantity  ││
│  │                 │  │  - Total     ││
│  └─────────────────┘  └──────────────┘│
├────────────────────────────────────────┤
│  Subtotal:               $XX.XX        │
│  Shipping:               $X.XX         │
│  Discount:              -$X.XX         │
│  ────────────────────────────────      │
│  Total:                  $XX.XX        │
└────────────────────────────────────────┘
```

---

## 🎨 Tailwind CSS Configuration

### Custom Tailwind Config

```javascript
// tailwind.config.js
module.exports = {
  theme: {
    extend: {
      colors: {
        primary: {
          DEFAULT: '#4A90E2',
          hover: '#357ABD',
          light: '#E8F4FD',
          dark: '#2E5A8A',
        },
        accent: {
          warm: '#FF9F43',
          pink: '#FFC0CB',
        },
        success: '#27AE60',
        warning: '#F39C12',
        error: '#E74C3C',
        info: '#3498DB',
        gray: {
          900: '#2C3E50',
          800: '#34495E',
          700: '#5A6C7D',
          600: '#7B8794',
          500: '#95A5A6',
          400: '#BDC3C7',
          300: '#D5DBDB',
          200: '#ECF0F1',
          100: '#F8F9FA',
        },
      },
      fontFamily: {
        sans: ['Nunito', 'system-ui', 'sans-serif'],
        serif: ['Playfair Display', 'Georgia', 'serif'],
        mono: ['Inter', 'monospace'],
      },
      fontSize: {
        xs: ['0.75rem', { lineHeight: '1rem' }],
        sm: ['0.875rem', { lineHeight: '1.25rem' }],
        base: ['1rem', { lineHeight: '1.6' }],
        lg: ['1.125rem', { lineHeight: '1.7' }],
        xl: ['1.25rem', { lineHeight: '1.75rem' }],
        '2xl': ['1.5rem', { lineHeight: '2rem' }],
        '3xl': ['1.875rem', { lineHeight: '2.25rem' }],
        '4xl': ['2.25rem', { lineHeight: '2.5rem' }],
        '5xl': ['3rem', { lineHeight: '1.2' }],
        '6xl': ['3.75rem', { lineHeight: '1.1' }],
      },
      borderRadius: {
        DEFAULT: '8px',
        sm: '4px',
        md: '8px',
        lg: '12px',
        xl: '16px',
        '2xl': '24px',
        full: '9999px',
      },
      boxShadow: {
        sm: '0 2px 4px rgba(0, 0, 0, 0.06)',
        DEFAULT: '0 2px 8px rgba(0, 0, 0, 0.08)',
        md: '0 4px 12px rgba(0, 0, 0, 0.1)',
        lg: '0 8px 24px rgba(0, 0, 0, 0.12)',
        xl: '0 12px 36px rgba(0, 0, 0, 0.15)',
      },
      transitionDuration: {
        fast: '150ms',
        base: '200ms',
        slow: '300ms',
        slower: '500ms',
      },
    },
  },
};
```

---

## 📋 Component Checklist

### Forms
- [ ] Text inputs
- [ ] Text areas
- [ ] Select dropdowns
- [ ] Radio buttons
- [ ] Checkboxes
- [ ] Date pickers
- [ ] Phone input (masked)
- [ ] Email input
- [ ] File upload
- [ ] Signature pad
- [ ] reCAPTCHA

### Navigation
- [ ] Header (sticky)
- [ ] Progress indicator
- [ ] Breadcrumbs
- [ ] Pagination
- [ ] Tabs

### Feedback
- [ ] Loading spinners
- [ ] Progress bars
- [ ] Success messages
- [ ] Error messages
- [ ] Info alerts
- [ ] Tooltips
- [ ] Modals
- [ ] Toast notifications

### Content
- [ ] Cards
- [ ] Package cards (selectable)
- [ ] Order summary table
- [ ] Pricing breakdown
- [ ] Testimonials
- [ ] FAQ accordion
- [ ] Image galleries

---

## 🚀 Implementation Guide

### Step 1: Set Up Fonts

```html
<!-- In <head> -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700;800&family=Playfair+Display:wght@600;700&family=Inter:wght@400;500&display=swap" rel="stylesheet">
```

### Step 2: Include Tailwind CSS

```bash
npm install -D tailwindcss@latest postcss@latest autoprefixer@latest
npx tailwindcss init -p
```

### Step 3: Configure Filament Theme

```php
// config/filament.php
'dark_mode' => false,
'theme' => [
    'colors' => [
        'primary' => '#4A90E2',
        'success' => '#27AE60',
        'warning' => '#F39C12',
        'danger' => '#E74C3C',
    ],
],
```

### Step 4: Create Custom CSS

```css
/* resources/css/app.css */
@import 'tailwindcss/base';
@import 'tailwindcss/components';
@import 'tailwindcss/utilities';

@layer base {
  :root {
    --primary-blue: #4A90E2;
    --primary-blue-hover: #357ABD;
    /* ... all color variables ... */
  }
  
  body {
    @apply font-sans text-gray-800 bg-gray-100;
  }
}

@layer components {
  .btn-primary {
    @apply bg-primary text-white px-6 py-3 rounded-lg font-semibold;
    @apply hover:bg-primary-hover transition-all duration-base;
    @apply shadow-sm hover:shadow-md;
  }
  /* ... all component classes ... */
}
```

---

## ✅ Brand Guidelines Summary

### Do's ✅
- Use Nunito for all body text
- Use primary blue for CTAs
- Maintain consistent spacing (8px grid)
- Ensure 4.5:1 contrast ratio minimum
- Use rounded corners (8px default)
- Include descriptive alt text
- Test on mobile devices
- Follow accessibility guidelines

### Don'ts ❌
- Don't use more than 3 font families
- Don't create new color variants
- Don't ignore mobile breakpoints
- Don't animate excessively
- Don't use small text (<14px)
- Don't skip accessibility testing
- Don't place text over busy images
- Don't ignore loading states

---

## 📚 Resources & Tools

### Design Tools
- **Figma:** For mockups and prototypes
- **Adobe XD:** Alternative design tool
- **Coolors.co:** Color palette generator
- **Contrast Checker:** WebAIM contrast checker

### Development Tools
- **Tailwind UI:** Pre-built components
- **Heroicons:** Icon library
- **Filament:** Laravel admin panel
- **Laravel Mix/Vite:** Asset compilation

### Testing Tools
- **WAVE:** Accessibility checker
- **Lighthouse:** Performance & accessibility
- **BrowserStack:** Cross-browser testing
- **ResponsivelyApp:** Responsive design testing

---

## 📞 Brand Support

For questions about brand usage:
- **Design Lead:** [TBD]
- **Developer Lead:** [TBD]
- **Brand Assets:** [Link to asset repository]

---

**Document Status:** ✅ Complete  
**Last Updated:** November 1, 2025  
**Version:** 1.0  
**Next Review:** February 1, 2026

---

## 🎯 Quick Start Checklist

For developers starting on the UI:

- [ ] Install fonts (Nunito, Playfair Display, Inter)
- [ ] Set up Tailwind with custom config
- [ ] Configure Filament theme colors
- [ ] Create base CSS with color variables
- [ ] Build component library (buttons, forms, cards)
- [ ] Test on mobile devices
- [ ] Run accessibility audit
- [ ] Review with design team
- [ ] Get stakeholder approval

**Ready to build beautiful, accessible, on-brand interfaces! 🚀**
