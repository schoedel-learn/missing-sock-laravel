# JotForm Overview & Executive Summary

**Form URL:** https://form.jotform.com/230024885645660  
**Company:** The Missing Sock Photography  
**Purpose:** School photography pre-order system  
**Analysis Date:** November 1, 2025

---

## 🎯 Executive Summary

The Missing Sock uses JotForm to manage pre-orders for school photography sessions across **149 schools** in the Miami/South Florida area. The form is a sophisticated **10-page wizard** with complex conditional logic, integrated Stripe payments, and appointment booking.

### Key Statistics
- **149 schools** served
- **73+ form fields**
- **10 pages** in multi-step wizard
- **11+ conditional logic rules**
- **6 package options**
- **Multiple add-ons and upgrades**
- **Stripe payment integration**
- **Time slot booking system**

### Business Model
1. Parents select their child's school
2. Choose photography packages
3. Pre-pay for school picture day
4. Book time slot for photo session
5. Receive digital gallery after session
6. Select final images within 5 days
7. Receive prints via school or home delivery

---

## 📋 Form Flow Overview

```
Page 1: School Selection & Registration Type
└─ Select school → Sets project type, deadline, backdrops
└─ Choose registration type (Prepay vs. Register only)
└─ Select backdrop(s) based on school project

Page 2: Your Information
└─ Parent/Guardian contact details
└─ reCAPTCHA verification

Page 3: Your Child's Information
└─ Number of children (1-3)
└─ Child details (name, class, teacher, DOB)
└─ Dynamic fields based on child count

Page 4: Session Details
└─ Sibling special option (+$5)
└─ Sibling package selection (if applicable)
└─ Package pose distribution

Page 5: Package Selection
└─ Main package ($48-$124)
└─ 4 Poses Digital upgrade (+$10)
└─ Second package (if two backdrops)
└─ Third package (if three children)
└─ Class picture options

Page 6: Enhance Your Pack
└─ Pose Perfection (+$14/$28/$42)
└─ Premium Retouch (+$12)
└─ Add-ons (prints, digital, mug)
└─ Special instructions

Page 7: Shipping
└─ School shipping (free) or Home ($7)
└─ Address collection (if home shipping)

Page 8: Ordering Preferences
└─ Auto-selection preference
└─ Time slot booking (calendar widget)
└─ Terms & conditions

Page 9: Order Summary
└─ Itemized order review
└─ Coupon code entry
└─ Final price calculation

Page 10: Authorization & Payment
└─ Photo session agreement
└─ Parent authorization
└─ Signature capture
└─ Stripe payment (if prepaying)
```

---

## 🏗 Technology Stack

### Current (JotForm)
- **Platform:** JotForm.com (EU hosting)
- **Frontend:** jQuery 3.7.1 + JotForm custom JS
- **Payments:** Stripe Elements (embedded iframe)
- **Signature:** jSignature (canvas-based)
- **Bot Protection:** Google reCAPTCHA v2
- **Appointments:** JotForm Appointment Field API
- **Fonts:** Nunito, Playfair Display, Inter
- **Theme:** Custom JotForm theme

### Target (Laravel)
- **Framework:** Laravel 10.x / 11.x
- **Form Builder:** Filament Forms v3 (recommended)
- **Frontend:** Livewire 3.x + Alpine.js
- **UI:** Tailwind CSS
- **Payments:** Laravel Cashier (Stripe)
- **Database:** MySQL / PostgreSQL
- **Queue:** Redis (for email/notification jobs)
- **Cache:** Redis
- **Storage:** S3 (for signatures, images)

---

## 🎨 Key Features to Replicate

### 1. Dynamic School Configuration
Each school has:
- Unique project name (e.g., "Tiny Planet ❄️ Winter 2025")
- Registration deadline
- Backdrop options (single or dual)
- Project type (Winter, Spring, Graduation, etc.)

### 2. Conditional Field Display
- Child fields multiply based on number of children
- Sibling packages appear only if "Sibling Special" selected
- Second package required if two backdrops selected
- Shipping address only if home delivery selected
- Pose Perfection pricing varies by child count

### 3. Complex Pricing Engine
```
Base Package → Optional Upgrades → Add-Ons → Shipping → Discount = Total
```

### 4. Multi-Step Validation
- Client-side validation (immediate feedback)
- Server-side validation (security)
- Progressive disclosure (show fields as needed)
- Save progress between steps

### 5. Payment Processing
- Stripe integration with SCA compliance
- Deferred payment intent (charge only on success)
- Optional registration without payment
- Coupon/discount code system

### 6. Time Slot Booking
- Calendar widget with available dates
- 30-minute slots
- Max 4 participants per slot
- 48-hour reschedule policy
- 24-hour cancellation policy

---

## 📊 Data Model Summary

### Core Entities
1. **Schools** (149 records)
2. **Projects** (school-specific session configs)
3. **Registrations** (parent submissions)
4. **Children** (1-3 per registration)
5. **Orders** (package + add-ons + pricing)
6. **Payments** (Stripe transactions)
7. **TimeSlots** (appointment bookings)
8. **Packages** (6 options)
9. **AddOns** (5 options)
10. **Coupons** (discount codes)

---

## 🚦 Migration Approach

### Strategy: Phased Migration

**Phase 1: Database & Models**
- Create all tables and relationships
- Seed schools and packages data
- Set up factories for testing

**Phase 2: Form UI**
- Build multi-step wizard with Filament
- Implement all fields with validation
- Add conditional logic

**Phase 3: Business Logic**
- Pricing calculator service
- Order processing workflow
- Email notification system

**Phase 4: Integrations**
- Stripe payment flow
- Signature capture
- reCAPTCHA
- Time slot booking

**Phase 5: Admin Panel**
- School management
- Order management
- Customer management
- Reporting dashboard

**Phase 6: Testing & Launch**
- Automated testing
- User acceptance testing
- Soft launch (single school)
- Full launch

---

## ⚠️ Critical Considerations

### 1. Data Migration
- Export existing JotForm submissions
- Map to new database schema
- Preserve historical orders
- Migrate customer data (GDPR compliant)

### 2. User Experience
- Must match or exceed current UX
- Mobile-responsive design
- Fast page loads
- Clear error messages

### 3. Business Continuity
- Zero downtime during migration
- Parallel running during transition
- Fallback plan if issues arise

### 4. Compliance
- PCI DSS (Stripe handles card data)
- COPPA (children's data protection)
- GDPR/CCPA (email consent, data rights)

### 5. Performance
- Handle concurrent orders during peak times
- Optimize for 1000+ orders per project
- Fast search and filtering in admin

---

## 📈 Success Metrics

### Technical
- [ ] All 73 fields replicated
- [ ] All 11 conditional rules working
- [ ] Payment success rate ≥99%
- [ ] Page load time <2 seconds
- [ ] Zero data loss during migration

### Business
- [ ] Reduce form abandonment by 10%
- [ ] Improve mobile conversion by 15%
- [ ] Reduce support tickets by 20%
- [ ] Enable future feature additions easily

---

## 🔗 Related Documents

- **[JOTFORM_02_SCHOOLS_DATA.md](JOTFORM_02_SCHOOLS_DATA.md)** - Complete school list
- **[JOTFORM_03_FORM_FIELDS.md](JOTFORM_03_FORM_FIELDS.md)** - All field definitions
- **[JOTFORM_04_CONDITIONAL_LOGIC.md](JOTFORM_04_CONDITIONAL_LOGIC.md)** - Logic rules
- **[JOTFORM_10_LARAVEL_IMPLEMENTATION.md](JOTFORM_10_LARAVEL_IMPLEMENTATION.md)** - Implementation guide

---

**Next Steps:**
1. Review this overview with stakeholders
2. Prioritize features for MVP
3. Begin Phase 1: Database design
4. Set up development environment

---

**Document Status:** ✅ Complete  
**Last Updated:** November 1, 2025  
**Version:** 1.0

