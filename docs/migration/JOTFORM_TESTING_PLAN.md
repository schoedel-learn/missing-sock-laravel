# JotForm Interactive Testing Plan

## Purpose
Systematically test all conditional logic paths in the JotForm to complete the analysis document.

---

## Test Scenarios

### Scenario 1: Single Child - Simple Flow
**Goal:** Document basic flow with minimal options

- Select School: Tiny Planet
- Backdrop: Winter
- Registration Type: Prepay
- Number of Children: One (1)
- Package: Single Smile ($48)
- No upgrades
- No add-ons
- School shipping
- Complete to payment page

**Expected Fields to Document:**
- Basic info fields
- Single child fields only
- Basic package selection
- No sibling fields

---

### Scenario 2: Two Children - Sibling Package
**Goal:** Test sibling special conditional logic

- Select School: Tiny Planet
- Backdrop: Winter
- Number of Children: Two (2)
- Sibling Special: Yes
- Sibling Package: Popular Pair ($65)
- Package Distribution: Include individuals

**Expected Fields to Document:**
- Child 2 fields appear
- Sibling package field appears
- Sibling pose distribution field
- Pricing: $65 + $5 = $70

---

### Scenario 3: Three Children - Multiple Packages
**Goal:** Test maximum children complexity

- Number of Children: Three (3)
- Sibling Special: Yes
- First Sibling Package: Popular Pair
- Second Sibling Package: Digital Duo

**Expected Fields to Document:**
- Child 3 fields appear
- Second sibling package field appears
- Third package selection field
- Complex pricing calculation

---

### Scenario 4: Two Backdrops School
**Goal:** Test two backdrop conditional logic

- Select School: [Find school with two backdrops]
- Has Two Backdrops: Yes
- Select both available backdrops
- Second Package: Required

**Expected Fields to Document:**
- Backdrop warning message
- Second package field (required)
- Backdrop-specific session options

---

### Scenario 5: All Upgrades & Add-Ons
**Goal:** Document all optional features

- 4 Poses Digital Upgrade: Yes
- Pose Perfection: Yes
- Premium Retouch: Yes
- Add-Ons:
  - Extra Smiles
  - Big Moments
  - Class Picture 8x10
  - Digital Add-On
  - Memory Mug
- Class Picture: Panorama 5x20
- Home Shipping: Yes

**Expected Fields to Document:**
- All upgrade fields
- All add-on checkboxes
- Retouch specification field
- Shipping address fields
- Maximum price calculation

---

### Scenario 6: Different Project Types
**Goal:** Test each project type for unique backdrops

**Test Projects:**
- School Pictures/Graduation
- Holidays (Winter + Christmas)
- Back To School
- Fall
- Spring

**For Each:**
- Document backdrop options
- Document session type options
- Capture screenshots

---

### Scenario 7: Registration Without Prepaying
**Goal:** Test non-payment flow

- Registration Type: Register without Pre-Paying
- Complete form
- Check if payment fields appear

**Expected Behavior:**
- Payment section hidden or disabled
- Form submits without payment

---

### Scenario 8: Order Summary & Coupons
**Goal:** Test pricing display and coupon system

- Build complex order
- Review order summary table
- Test coupon code field
- Document pricing breakdown

**Expected Fields:**
- Order summary table structure
- Coupon input field
- Discount calculation
- Final total calculation

---

### Scenario 9: Terms & Authorization
**Goal:** Document legal/compliance fields

- Photo Session Participation Agreement
- Picture Day Authorization checkbox
- Signature pad functionality
- Email opt-in
- Cancellation policy agreement

**Expected Fields:**
- Terms text content
- Signature pad (jSignature)
- Checkbox options
- Required validation

---

### Scenario 10: Time Slot Booking
**Goal:** Document appointment system

- Navigate to time slot selection
- View available dates
- Select time slot
- Document booking constraints

**Expected Behavior:**
- Calendar widget
- 30-minute slots
- 4 participants max per slot
- Terms and conditions display

---

## Data to Extract

### From Page Source:
- [ ] All field IDs and names
- [ ] All validation rules
- [ ] All calculation formulas (JavaScript)
- [ ] All conditional show/hide rules
- [ ] Hidden field values
- [ ] Default values

### From CSS:
- [ ] Brand colors (hex codes)
- [ ] Font families and sizes
- [ ] Button styles
- [ ] Layout breakpoints
- [ ] Custom theme properties

### From Network Requests:
- [ ] Form submission endpoint
- [ ] Appointment API endpoint
- [ ] Stripe integration details
- [ ] reCAPTCHA configuration
- [ ] Any other API calls

### From Screenshots:
- [ ] Initial state
- [ ] Each page of form
- [ ] Each conditional state
- [ ] Order summary examples
- [ ] Payment page

---

## Testing Checklist

- [ ] Test Scenario 1: Single Child
- [ ] Test Scenario 2: Sibling Package
- [ ] Test Scenario 3: Three Children
- [ ] Test Scenario 4: Two Backdrops
- [ ] Test Scenario 5: All Upgrades
- [ ] Test Scenario 6: Project Types
- [ ] Test Scenario 7: No Prepay
- [ ] Test Scenario 8: Order Summary
- [ ] Test Scenario 9: Terms & Auth
- [ ] Test Scenario 10: Time Slots

- [ ] Extract CSS color scheme
- [ ] Extract all JavaScript calculation logic
- [ ] Document all API endpoints
- [ ] Create field-to-database mapping
- [ ] Document validation rules
- [ ] Create flow diagrams

---

## Next Steps After Testing

1. **Update JOTFORM_COMPLETE_ANALYSIS.md** with all findings
2. **Create database schema** based on all fields
3. **Create Laravel migration files** for schema
4. **Document API integration requirements**
5. **Create user flow diagrams**
6. **List all business rules** for Laravel implementation

---

**Status:** Ready to begin systematic testing
**Start Date:** November 1, 2025

