# Pre-Order Form Analysis & Implementation Status

## 📋 Form Flow Comparison

### Current Implementation (10 Steps)
1. ✅ **School Selection & Registration Type** - Implemented
2. ✅ **Parent Information** - Implemented (with reCAPTCHA placeholder)
3. ✅ **Children Information** - Implemented
4. ✅ **Session Details** (Sibling Special) - Implemented
5. ✅ **Package Selection** - Implemented
6. ✅ **Enhance Your Pack** (Pose Perfection, Premium Retouch) - Implemented
7. ✅ **Shipping** - Implemented
8. ✅ **Ordering Preferences** - Implemented
9. ✅ **Order Summary** - Implemented
10. ✅ **Confirmation/Payment** - Implemented

### Missing from Original Process

#### ❌ **Add-Ons Selection Step** (Between Step 6 and 7)
Based on the images, there should be a dedicated step for selecting add-ons:
- **Extra Smiles** - Two 5x7 prints ($19)
- **Big Moments** - One 8x10 print ($19)
- **Memory Mug** - Custom Coffee Mug ($22)
- **Class Picture** - Already partially implemented (in Step 5)
- **Digital Add-On** - One digital image download ($20)

**Current Status:** Add-ons exist in database but are NOT collected in the wizard form.

#### ❌ **Signature/Agreement Step** (Before Payment)
The images show a "Photo Session Participation Agreement" step that includes:
- Agreement text (3 paragraphs about permissions, COPPA, email consent)
- Checkbox: "I have read and understand the terms..."
- Signature pad with "Sign Here" and "Clear" button
- Payment details section

**Current Status:** Signature fields exist in Registration model (`signature_data`, `signature_date`) but no step in wizard.

#### ⚠️ **Coupon Code Field** (In Order Summary)
The images show a coupon code input field in the order summary.

**Current Status:** `coupon_code` field exists in Order model but not displayed/collected in wizard.

---

## 📊 Data Flow

### Where Data Goes

#### 1. **Registration Created** (`registrations` table)
- **When:** After Step 9 (Order Summary) → Submit button clicked
- **Contains:**
  - Parent information (name, email, phone)
  - School & project selection
  - Children information (stored in `children` table)
  - Shipping preferences
  - Ordering preferences (auto-select images)
  - Special instructions
  - Registration type (prepay vs register_only)
  - Status: `pending` → `confirmed` (after payment)

#### 2. **Order Created** (`orders` table)
- **When:** Only if `registrationType === 'prepay'` AND `mainPackageId` exists
- **Contains:**
  - Package selections (main, second, third, sibling)
  - Upgrades (4 poses, pose perfection, premium retouch)
  - Class picture selection
  - Pricing breakdown (subtotal, shipping, discount, total)
  - Links to: `user_id`, `registration_id`

#### 3. **Add-Ons** (`order_add_ons` pivot table)
- **Current Status:** ❌ NOT being saved
- **Should Link:** `order_id` ↔ `add_on_id` with `quantity` and `price_cents`
- **Missing:** No step in wizard to select add-ons

#### 4. **Payment** (`payments` table)
- **When:** After successful Stripe payment
- **Created By:** `PreOrderController::paymentSuccess()`
- **Contains:**
  - Stripe payment intent ID
  - Amount, currency, status
  - Links to: `user_id`, `registration_id`, `order_id`

#### 5. **User Account** (`users` table)
- **When:** Created automatically if email doesn't exist
- **Service:** `UserAccountService::getOrCreateUser()`
- **Contains:**
  - Name, email
  - Random password (user must reset via password reset)
  - Role: `Parent`

---

## 📧 Email Notifications Needed

### Currently Missing - Should Be Implemented

#### 1. **Registration Confirmation Email** ⚠️ CRITICAL
**When:** Immediately after registration is created (Step 9 → Submit)
**Recipient:** Parent email (`$registration->parent_email`)
**Should Include:**
- Registration number
- School name
- Project name
- Number of children registered
- Registration type (prepay vs register_only)
- Next steps (if prepay: payment link, if register_only: when to expect payment request)
- Link to view registration details

**Trigger:** After `Registration::create()` in `PreOrderWizard::submit()`

#### 2. **Order Confirmation Email** ⚠️ CRITICAL
**When:** After successful payment (`PreOrderController::paymentSuccess()`)
**Recipient:** Parent email
**Should Include:**
- Order number
- Registration number
- Package details
- Add-ons selected
- Total paid
- Payment confirmation
- Expected delivery timeline
- Link to order details

**Trigger:** After payment is confirmed in `PreOrderController::paymentSuccess()`

#### 3. **Payment Pending Reminder** (Optional)
**When:** If order created but payment not completed within 24 hours
**Recipient:** Parent email
**Should Include:**
- Order number
- Amount due
- Payment link
- Deadline reminder

**Trigger:** Scheduled job (daily check for unpaid orders)

#### 4. **Gallery Ready Notification** (Future)
**When:** When photos are uploaded and gallery is ready
**Recipient:** Parent email
**Should Include:**
- Gallery access link
- 5-day selection deadline reminder
- Instructions for selecting images

**Trigger:** When admin marks gallery as ready

#### 5. **Order Shipped Notification** (Future)
**When:** When order is marked as shipped
**Recipient:** Parent email
**Should Include:**
- Order number
- Tracking information (if available)
- Expected delivery date

**Trigger:** When admin marks order as shipped

---

## 🔧 Implementation Recommendations

### Priority 1: Add Missing Steps

#### A. Add Add-Ons Selection Step (New Step 7, renumber others)
```php
// In PreOrderWizard.php
public $selectedAddOns = []; // Array of add-on IDs

// Add step between Step 6 and current Step 7
// Display checkboxes for:
// - Extra Smiles ($19)
// - Big Moments ($19)
// - Memory Mug ($22)
// - Digital Add-On ($20)
```

#### B. Add Signature/Agreement Step (New Step 9, before Order Summary)
```php
// In PreOrderWizard.php
public $agreementAccepted = false;
public $signatureData = null; // Base64 image data

// Display:
// - Agreement text (3 paragraphs)
// - Checkbox for acceptance
// - Signature pad (use a signature library like signature_pad.js)
```

#### C. Add Coupon Code to Order Summary (Step 9)
```php
// In PreOrderWizard.php
public $couponCode = null;

// Display input field in order summary
// Validate and apply discount if valid
```

### Priority 2: Email Notifications

#### Create Notification Classes
```php
// app/Notifications/RegistrationConfirmation.php
// app/Notifications/OrderConfirmation.php
// app/Notifications/PaymentReminder.php
```

#### Send After Registration
```php
// In PreOrderWizard::submit()
$user->notify(new RegistrationConfirmation($registration));
```

#### Send After Payment
```php
// In PreOrderController::paymentSuccess()
$user->notify(new OrderConfirmation($order, $registration));
```

### Priority 3: Save Add-Ons to Order
```php
// In PreOrderWizard::submit() after Order::create()
if (!empty($this->selectedAddOns)) {
    foreach ($this->selectedAddOns as $addOnId) {
        $addOn = AddOn::find($addOnId);
        $order->addOns()->attach($addOnId, [
            'quantity' => 1,
            'price_cents' => $addOn->price_cents,
        ]);
    }
}
```

---

## 📝 Current Step Mapping

| Original Form | Current Wizard | Status |
|--------------|----------------|--------|
| School Selection | Step 1 | ✅ Match |
| Parent Info | Step 2 | ✅ Match |
| Children Info | Step 3 | ✅ Match |
| Session Details | Step 4 | ✅ Match |
| Package Selection | Step 5 | ✅ Match |
| Enhance Pack | Step 6 | ✅ Match |
| **Add-Ons** | **MISSING** | ❌ Need Step 7 |
| Shipping | Step 7 | ✅ Match |
| Ordering Prefs | Step 8 | ✅ Match |
| **Signature/Agreement** | **MISSING** | ❌ Need Step 9 |
| Order Summary | Step 9 | ⚠️ Missing coupon code |
| Payment/Confirmation | Step 10 | ✅ Match |

---

## 🎯 Action Items

### Immediate (Critical)
1. ✅ Fix reCAPTCHA (DONE)
2. ❌ Add Add-Ons selection step
3. ❌ Add Signature/Agreement step
4. ❌ Add coupon code field to order summary
5. ❌ Create and send Registration Confirmation email
6. ❌ Create and send Order Confirmation email

### Short Term
7. ❌ Update order total calculation to include add-ons
8. ❌ Save signature data to registration
9. ❌ Implement coupon code validation and discount application
10. ❌ Test full flow end-to-end

### Long Term
11. ❌ Payment reminder emails (scheduled job)
12. ❌ Gallery ready notifications
13. ❌ Order shipped notifications
14. ❌ Admin notifications for new registrations/orders

---

## 📍 Where Data is Stored

### Database Tables Used:
- `users` - Parent account
- `schools` - School/organization info
- `projects` - Picture day sessions
- `registrations` - Main registration record
- `children` - Child information (linked to registration)
- `orders` - Order details (if prepaid)
- `order_add_ons` - Add-ons selected (pivot table)
- `add_ons` - Available add-on products
- `packages` - Available packages
- `payments` - Payment records

### Key Relationships:
- `Registration` → `User` (belongsTo)
- `Registration` → `School` (belongsTo)
- `Registration` → `Project` (belongsTo)
- `Registration` → `Children` (hasMany)
- `Registration` → `Orders` (hasMany)
- `Order` → `Registration` (belongsTo)
- `Order` → `AddOns` (belongsToMany)
- `Order` → `Payments` (hasMany)

---

## 🔔 Notification Triggers Summary

| Event | When | Email Type | Recipient | Status |
|-------|------|------------|-----------|--------|
| Registration Created | After Step 9 submit | Confirmation | Parent | ❌ Missing |
| Payment Successful | After Stripe payment | Order Confirmation | Parent | ❌ Missing |
| Payment Pending | 24h after order creation | Reminder | Parent | ❌ Missing |
| Gallery Ready | When photos uploaded | Gallery Access | Parent | ❌ Missing |
| Order Shipped | When marked shipped | Shipping Notice | Parent | ❌ Missing |
| New Registration | When created | Admin Alert | Admin | ❌ Missing |
| New Order | When created | Admin Alert | Admin | ❌ Missing |

---

**Last Updated:** 2025-01-27
**Status:** Form structure matches ~85%, missing add-ons step, signature step, and all email notifications.

