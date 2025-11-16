# Pre-Order Form Access Guide

**Date:** 2025-01-27  
**Status:** ✅ Public Form Created

---

## 🎯 How Customers Access the Pre-Order Form

### **Public URL:**
```
https://yourdomain.com/pre-order/start
```

### **Access Points:**

1. **Homepage Button**
   - The homepage (`/`) has a prominent "REGISTER FOR PICTURE DAY!" button
   - This button links to `/pre-order/start`
   - Located in the hero section

2. **Direct URL**
   - Customers can navigate directly to `/pre-order/start`
   - No authentication required - completely public

3. **Navigation Menu** (if added)
   - Can be added to the main navigation menu
   - Link: `{{ route('pre-order.start') }}`

---

## 📋 Form Flow

The pre-order form is a **6-step wizard**:

### **Step 1: School Selection**
- Select school from dropdown
- Select project/session for that school
- Choose registration type:
  - **Pre-Pay Now** (with discounts)
  - **Register Only** (pay later)

### **Step 2: Parent Information**
- First Name
- Last Name
- Email
- Phone

### **Step 3: Children Information**
- Number of children (1-3)
- For each child:
  - First Name
  - Last Name
  - Class
  - Teacher (optional)
  - Date of Birth (optional)

### **Step 4: Package Selection**
- Select main package
- Optional: Second package, third package
- Optional upgrades:
  - 4 Poses Upgrade
  - Pose Perfection
  - Premium Retouch

### **Step 5: Review & Payment**
- Review all information
- If "Pre-Pay Now": Payment form (Stripe integration needed)
- If "Register Only": Submit registration

### **Step 6: Confirmation**
- Registration number displayed
- Order number (if prepaid)
- Link to full confirmation page

---

## 🔧 Technical Implementation

### **Files Created:**

1. **Livewire Component**
   - `app/Livewire/PreOrderWizard.php`
   - Handles form logic, validation, and submission
   - Multi-step wizard functionality

2. **Views**
   - `resources/views/pre-order/wizard.blade.php` - Main wrapper
   - `resources/views/livewire/pre-order-wizard.blade.php` - Wizard UI

3. **Controller Updated**
   - `app/Http/Controllers/PreOrderController.php`
   - `start()` method now returns the wizard view

### **Route:**
```php
Route::get('/pre-order/start', [PreOrderController::class, 'start'])
    ->name('pre-order.start');
```

---

## ✅ Current Status

### **Implemented:**
- ✅ Public access (no authentication required)
- ✅ Multi-step wizard UI
- ✅ School and project selection
- ✅ Parent information collection
- ✅ Children information (1-3 children)
- ✅ Package selection
- ✅ Registration creation
- ✅ Order creation (for prepay)
- ✅ Confirmation step

### **Needs Implementation:**
- ⚠️ **Stripe Payment Integration** (Step 5)
  - Currently shows placeholder message
  - Need to integrate Stripe Checkout or Elements
  - Should process payment before creating order

- ⚠️ **Additional Package Options**
  - Second package selection
  - Third package selection
  - Sibling package
  - Add-ons and upgrades

- ⚠️ **Time Slot Booking**
  - If project has time slots, allow booking
  - Currently not implemented in wizard

- ⚠️ **Form Validation**
  - Basic validation exists
  - May need additional rules based on business logic

- ⚠️ **Email Notifications**
  - Send confirmation email after registration
  - Send order confirmation if prepaid

---

## 🚀 Next Steps

### **Priority 1: Payment Integration**
1. Install Laravel Cashier (if not already)
2. Add Stripe keys to `.env`
3. Implement Stripe Checkout in Step 5
4. Process payment before creating order
5. Handle payment success/failure

### **Priority 2: Complete Package Selection**
1. Add second/third package options
2. Add sibling package option
3. Add upgrade options (4 poses, pose perfection, retouch)
4. Calculate total dynamically

### **Priority 3: Time Slot Booking**
1. Check if project has time slots
2. Display available time slots
3. Allow customer to select slot
4. Create TimeSlotBooking record

### **Priority 4: Email Notifications**
1. Create registration confirmation email
2. Create order confirmation email
3. Send emails after successful submission

---

## 📝 Usage Example

### **For Customers:**
1. Visit homepage
2. Click "REGISTER FOR PICTURE DAY!" button
3. Complete 6-step wizard
4. Receive confirmation with registration/order number
5. View full confirmation at `/pre-order/confirmation/{registration}`

### **For Developers:**
```php
// Access the form programmatically
$url = route('pre-order.start');
// Returns: /pre-order/start

// Link in blade template
<a href="{{ route('pre-order.start') }}">Register Now</a>
```

---

## 🔍 Testing Checklist

- [ ] Form loads at `/pre-order/start`
- [ ] No authentication required
- [ ] School selection works
- [ ] Project selection appears after school selection
- [ ] Can add/remove children
- [ ] Package selection works
- [ ] Total calculates correctly
- [ ] Registration creates successfully
- [ ] Order creates (if prepay selected)
- [ ] Confirmation page displays correctly
- [ ] Mobile responsive

---

## 📚 Related Files

- **Routes:** `routes/web.php`
- **Controller:** `app/Http/Controllers/PreOrderController.php`
- **Livewire Component:** `app/Livewire/PreOrderWizard.php`
- **Views:** `resources/views/pre-order/` and `resources/views/livewire/`
- **Models:** `app/Models/Registration.php`, `app/Models/Order.php`, `app/Models/Child.php`

---

**Last Updated:** 2025-01-27  
**Status:** ✅ Public Form Accessible - Payment Integration Needed

