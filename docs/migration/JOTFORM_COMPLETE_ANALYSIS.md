# Complete JotForm Analysis for Laravel Migration
## The Missing Sock Pre-Order Form Analysis

**Form URL:** https://form.jotform.com/230024885645660  
**Analysis Date:** November 1, 2025  
**Purpose:** Complete documentation for Laravel application migration

---

## Executive Summary

This document provides a comprehensive analysis of The Missing Sock's JotForm pre-order system, including all form fields, conditional logic, pricing calculations, and business rules necessary to recreate the system in Laravel.

---

## Table of Contents

1. [Form Structure Overview](#form-structure-overview)
2. [All Schools List](#all-schools-list)
3. [Form Fields & Types](#form-fields--types)
4. [Conditional Logic Mapping](#conditional-logic-mapping)
5. [Pricing & Calculation Logic](#pricing--calculation-logic)
6. [Package Options](#package-options)
7. [Backdrop Options](#backdrop-options)
8. [Payment Integration](#payment-integration)
9. [Technical Integrations](#technical-integrations)
10. [Brand Guidelines](#brand-guidelines)

---

## Form Structure Overview

The form is a multi-step wizard with the following pages:
1. **School Selection & Registration Type**
2. **Your Information** (Parent/Guardian)
3. **Your Child's Information** (Up to 3 children)
4. **Session Details** (Backdrop selection, sibling options)
5. **Package Selection**
6. **Enhance Your Pack** (Add-ons and services)
7. **Shipping**
8. **Ordering Preferences**
9. **Order Summary**
10. **Authorization & Payment**

---

## All Schools List

Total Schools: **149**

### Complete School List (from dropdown):

1. Adhere Academy
2. Advanced Achievers Academy Preschool
3. All God's Children Christian Academy
4. Archimedean Academy
5. Archimedean Academy Kindergarten
6. Artec Academy 1
7. Artec Academy 2 Child Care Center
8. Atlantic Montessori Academy
9. Aventura Learning Center II
10. Aventura Learning Center III
11. B. Wright Leadership Academy
12. Baldwin Academy East Campus
13. Baldwin Academy South Campus
14. Beautiful Beginnings
15. Biscayne Park School & Early Learning Center
16. Miami Shores Early Learning Center
17. Broward Christian Academy
18. Bright Kids Bilingual Preschool
19. Carousel Of Angels
20. Centner Academy - Elementary and Middle School
21. Centner Academy - Preschool
22. Chai Tots Preschool
23. Christ Church Preschool
24. Clever Oaks Montessori School
25. Community Christian School
26. Core Learning Center
27. Cornerstone Christian Academy
28. Cornerstone of Hollywood
29. Creative Child Learning Center Coral Springs
30. Cutler Bay Christian Academy
31. Davie Christian School
32. Diamond Learning Center
33. Discover Montessori Academy Miami Lakes
34. Discover Montessori Academy PSN
35. Doral Preschool
36. Early Years Academy
37. Early Years Montessori Academy
38. Emerald Hills School
39. Excel Kids Academy Miami Gardens Campus
40. Fidelis Academy and Preschool
41. Future Kids Academy At Sunrise
42. Get Smart Kids Academy North Miami
43. Get Smart Kids Academy North Miami Beach
44. Gladeview Christian School
45. Green Children's House Montessori School
46. Green Explorers Academy
47. Guidepost Montessori at Hollywood Beach
48. Guidepost Montessori Palm Beach Gardens
49. Hallandale House of Learning
50. Holy Temple Christian Academy
51. Home Away From Home Pembroke Pines
52. I Am Kids Academy
53. Imagine Charter School at Weston
54. International Bilingual Preschool
55. Just kids Center II (My Little World)
56. Key Point Academy Aventura
57. Key Point Academy Coral Gables
58. Key Point Academy Doral
59. Key Point Academy
60. Kiddie Academy of Plantation
61. Kids World International Academy
62. Kinder Clues Academy
63. King's Academy
64. Kingdom Academy I
65. Kingdom Academy Preschool
66. KLA Schools of Boynton Beach
67. KLA Schools of Coconut Creek
68. KLA Schools of Coral Gables
69. KLA Schools of Doral
70. KLA Schools of Fort Lauderdale
71. KLA Schools of North Bay Village
72. KLA Schools of North Miami Beach
73. KLA Schools of Palmetto Bay
74. KLA Schools of West Kendall
75. Lamb of God Lutheran School
76. Learning Scope Academy
77. Learning Village
78. Le Petit Prince - Bilingual Campus (West Campus)
79. Le Petit Prince - French Campus/Immersion Program (East Campus)
80. Little Angels Preschool Corp
81. Little Bees Academy
82. Little Bethelites Preschool Fort Lauderdale
83. Little Bethelites Preschool II
84. Little Kingdom Child Care Center
85. Little Learners
86. Living Water Christian Academy
87. Lycee Franco-American
88. Memorial Lutheran School
89. Menininho Menininha Enrichment Center
90. Menininho Menininha Preparatory
91. Miami Christian School
92. Miami Shores Community Church
93. Miami Jewish Montessori
94. Miami Springs Learning Center
95. Middle River Early Learning Center
96. Midtown Jewish Preschool
97. Montessori Academy at St. Johns
98. Montessori Children's House
99. Montessori Ivy League Academy
100. Montgomery Christian Academy
101. Moore House Academy
102. My Little Family Preschool
103. My Little World
104. Nana's Preschool
105. New Hope SDA Learning Center
106. New Hope Southwest Ranches Christian Academy
107. New Generation Montessori Boca Raton
108. New Generation Montessori Delray Beach
109. New Generation Montessori at Ft Lauderdale
110. New Generation Montessori at Pompano Beach
111. New Generation Montessori Lake Clarke
112. New Generation Montessori West Palm Beach
113. Nob Hill Academy II Pembroke Pines
114. North Dade Regional Academy 20827 NW
115. North Dade Regional Academy Day Care 1822 NW
116. North Miami Beach Learning Center
117. Open Valley Preschool Academy
118. Our Sacred Academy
119. Panda Little Academy
120. Paramount Learning Center
121. Permission to Succeed Education Center
122. Pine Island Montessori
123. Preschool Kids Planet
124. Preschool of The Arts in Parkland
125. Pushkin Academy Miami
126. Rise to the Top Preschool
127. Shanes Learning Center
128. Shanti Kids Preschool
129. Shepherd Of God Christian Academy
130. Sol Academy
131. South Florida Montessori Academy
132. St. Malachy Catholic School
133. Tangerine Montessori
134. Temple Dor Dorim Early Childhood Center
135. The Academy at Griffin Harbor
136. The Children's First Preschool Early Learning Center
137. The Embassy Academy
138. The Emery & Mimi Green Chabad Preschool
139. The Gan Frida North Miami Beach
140. The Gan Frida/ Tamim Sunny Isles
141. The Goddard School of Greater Heights (Caterpillar Campus)
142. The Goddard School of Greater Heights (Music Campus)
143. The Goddard School of Greater Heights (Space Campus)
144. The Keebis Preschool
145. The Learning World Academy Doral
146. The Learning World Academy Venetian
147. The Nurtury Montessori School
148. The Randazzo School Lower Campus
149. The Randazzo School Upper Campus
150. The Thinking Child Academy
151. **Tiny Planet** (Example school - Winter 2025)
152. Tiny Tots Kingdom
153. Tippi Toes Dance
154. Tippi Toes Boynton Beach
155. Tutor Me Private School
156. Unique Care Academy
157. Village Montessori Coral Way
158. Village Montessori Killian
159. Village Montessori Shenandoah
160. Viva Christian Academy at Weston
161. Viva Christian Academy at Davie
162. Wee Kids Preschool (North)
163. Wee Kids Preschool (South)
164. Weston Learning Academy
165. Wonderworld Montessori Academy
166. World to Grow Learning Center I
167. World to Grow Learning Center II
168. Yeladim Miami Preschool

**Note:** School selection triggers dynamic fields including:
- Registration deadline (hidden, auto-populated)
- Has Two Backdrops? (hidden, auto-populated)
- Assigned Project Name (hidden, auto-populated)

---

## Form Fields & Types

### Page 1: School Selection & Registration Type

#### Field 1: Language Selection
- **Type:** Dropdown/Combobox
- **Options:**
  - English (US) - Default
  - Español
- **Behavior:** Changes form language

#### Field 2: Select Your Child's School *
- **Type:** Dropdown/Select
- **Required:** Yes
- **Options:** 149 schools (see list above)
- **Behavior:** 
  - Triggers conditional backdrop options
  - Sets registration deadline
  - Sets "Has Two Backdrops?" flag
  - Sets "Assigned Project Name"

#### Field 3: Registration Deadline (Do not touch)
- **Type:** Date (3 separate inputs: Month, Day, Year + combined Date field)
- **Readonly:** Yes
- **Format:** MM-DD-YYYY
- **Behavior:** Auto-populated based on school selection

#### Field 4: Has Two Backdrops? (Do not touch)
- **Type:** Radio Group
- **Options:**
  - Yes
  - No (Default)
- **Readonly:** Yes
- **Behavior:** Auto-determined based on school/project

#### Field 5: Assigned Project Name
- **Type:** Text Input (Hidden)
- **Readonly:** Yes
- **Example:** "Tiny Planet ❄️ Winter 2025"
- **Behavior:** Auto-populated from school selection

#### Field 6: Backdrop Selection (Conditional)
Multiple backdrop fields exist but only show based on school/project:

**IF Has Two Backdrops = Yes:**
- **Field:** "Choose your child's session backdrop:"
  - **Type:** Checkbox Group
  - **Options:**
    - Spring
    - Graduation
  - **Required:** No

**IF Project Type = School Pictures/Graduation:**
- **Field:** "Choose your child's session backdrop: *"
  - **Type:** Checkbox Group (Required)
  - **Options:**
    - School Picture
    - Graduation

**IF Project Type = Holidays:**
- **Field:** "Choose your child's Holidays backdrop: *"
  - **Type:** Checkbox Group (Required)
  - **Options:**
    - Winter
    - Christmas

**IF Project Type = Back To School:**
- **Field:** "Select your child's session backdrop: *"
  - **Type:** Checkbox (Required)
  - **Options:**
    - Back To School

**IF Project Type = Fall:**
- **Field:** "Select your child's session backdrop: *"
  - **Type:** Checkbox (Required)
  - **Options:**
    - Fall

**IF Project Type = Winter:**
- **Field:** "Select your child's Winter session backdrop: *"
  - **Type:** Checkbox (Required)
  - **Options:**
    - Winter

**IF Project Type = Christmas:**
- **Field:** "Select your child's Christmas session backdrop: *"
  - **Type:** Checkbox (Required)
  - **Options:**
    - Christmas

#### Field 7: Session Type Selection (Conditional)
- **Field:** "xxPlease, select your child's session type"
- **Type:** Radio Group
- **Options:**
  - Graduation
  - Class Picture Only
- **Behavior:** Conditional based on project type

#### Field 8: Picture Day Registration Type
- **Field:** "Picture Day is Here! How Do You Want to Join?"
- **Type:** Radio Group
- **Default:** "Prepay and Unlock All Benefits" (selected)
- **Options:**
  - Prepay and Unlock All Benefits
  - Register without Pre-Paying
- **Behavior:** Affects which packages/options are available

---

### Page 2: Your Information

#### Field 9: First Name *
- **Type:** Text Input
- **Required:** Yes

#### Field 10: Last Name *
- **Type:** Text Input
- **Required:** Yes

#### Field 11: Email Address *
- **Type:** Email Input
- **Required:** Yes
- **Validation:** Email format

#### Field 12: Phone number *
- **Type:** Phone Input (Masked)
- **Required:** Yes
- **Format:** (000) 000-0000
- **Placeholder:** "(000) 000-0000"

#### Field 13: reCAPTCHA *
- **Type:** Google reCAPTCHA v2
- **Required:** Yes
- **Site Key:** 6LcG3CgUAAAAAGOEEqiYhmrAm6mt3BDRhTrxWCKb

---

### Page 3: Your Child's Information

#### Field 14: Number of Children
- **Field:** "So, how many kids are we signing up today?"
- **Type:** Radio Group
- **Default:** "One (1)" (selected)
- **Options:**
  - One (1)
  - Two (2)
  - Three (3)
- **Behavior:** Shows/hides child fields dynamically

#### Child 1 Fields (Always Visible):

**Field 15:** Student's First Name *
- **Type:** Text Input
- **Required:** Yes

**Field 16:** Student's Last Name *
- **Type:** Text Input
- **Required:** Yes

**Field 17:** Student's Class Name *
- **Type:** Text Input
- **Required:** Yes

**Field 18:** Student's Teacher Name
- **Type:** Text Input
- **Required:** No

**Field 19:** Student's Date of Birth
- **Type:** Date Picker (3 inputs: Month, Day, Year + Date field)
- **Required:** Yes
- **Format:** MM-DD-YYYY
- **Placeholder:** "MM-DD-YYYY"
- **Button:** "Choose Date"

#### Child 2 Fields (Shown IF Number of Children = Two or Three):

**Field 20:** Student's First Name
- **Type:** Text Input
- **Required:** No (but required if Child 2 visible)

**Field 21:** Student's Last Name
- **Type:** Text Input
- **Required:** No (but required if Child 2 visible)

**Field 22:** Student's Class Name
- **Type:** Text Input
- **Required:** Yes (when visible)

**Field 23:** Student's Date of Birth
- **Type:** Date Picker
- **Required:** Yes (when visible)

#### Child 3 Fields (Shown IF Number of Children = Three):

**Field 24:** Student's First Name
- **Type:** Text Input
- **Required:** No (but required if Child 3 visible)

**Field 25:** Student's Last Name
- **Type:** Text Input
- **Required:** No (but required if Child 3 visible)

**Field 26:** Student's Class Name
- **Type:** Text Input
- **Required:** Yes (when visible)

**Field 27:** Student's Date of Birth
- **Type:** Date Picker
- **Required:** Yes (when visible)

---

### Page 4: Session Details

#### Field 28: Sibling Special Selection
- **Field:** "Do you want to Include the Sibling Special to your session?"
- **Type:** Radio Group
- **Options:**
  - Yes, include the Sibling Special for an extra $5 and have them pose together
  - No, I'll purchase separate packs for each child
- **Behavior:** 
  - Shows sibling package options if "Yes"
  - Triggers sibling package pricing

#### Field 29: Sibling Package Selection (Conditional)
**IF Sibling Special = Yes:**

- **Field:** "Select Your Siblings Package"
- **Type:** Radio Group
- **Options:**
  - Popular Pair - $65
  - Picture Perfect - $79
  - Digital Duo - $55
  - Triple Treat - $65
  - Fantastic Four - $124

#### Field 30: Second Sibling Package (Conditional)
**IF Number of Children = Three AND Sibling Special = Yes:**

- **Field:** "Select Your Second Siblings Package"
- **Type:** Radio Group
- **Options:** Same as Field 29

#### Field 31: Package Pose Distribution (Conditional)
**IF Sibling Package Selected:**

- **Field:** "Please select your package pose distribution you prefer:"
- **Type:** Radio Group
- **Options:**
  - Yes, include the individuals
  - No, I want them together

#### Field 32: Second Pack Requirement Notice (Conditional)
**IF Has Two Backdrops = Yes:**

- **Field:** Notice about second pack being mandatory
- **Type:** Information Text
- **Content:** "The second Pack is mandatory since you have selected two backdrops. Learn more about backdrop selection."

---

### Page 5: Package Selection

#### Field 33: Main Package Selection *
- **Field:** "Select your child's Main Package *"
- **Type:** Radio Group
- **Required:** Yes
- **Options:**
  - Single Smile - $48
  - Popular Pair - $65
  - Picture Perfect - $79
  - Digital Duo - $55
  - Triple Treat - $65
  - Fantastic Four - $124

#### Field 34: Pack#1 Total (Hidden Calculation)
- **Type:** Number Input (Readonly)
- **Placeholder:** "e.g., 23"
- **Behavior:** Auto-calculated from Main Package selection

#### Field 35: Main Package Hidden Text (Hidden)
- **Type:** Text Input (Readonly)
- **Behavior:** Stores selected package name

#### Field 36: # Poses (Main Package) (Hidden)
- **Type:** Number Input (Readonly)
- **Placeholder:** "e.g., 23"
- **Behavior:** Stores pose count for main package

#### Field 37: 4 Poses Digital Upgrade
- **Field:** "Would you like to upgrade to 4 Poses Digital for only $10?"
- **Type:** Radio Group
- **Default:** "No, thank you"
- **Options:**
  - Yes, that would be great!
  - No, thank you
- **Behavior:** Adds $10 if selected

#### Field 38: 4 Pose Digital Total (Hidden Calculation)
- **Type:** Number Input (Readonly)
- **Behavior:** Shows $10 if upgrade selected, $0 otherwise

#### Field 39: Second Package Selection (Conditional)
**IF Has Two Backdrops = Yes:**

- **Field:** "Select your second Package"
- **Type:** Radio Group
- **Required:** Yes (when Has Two Backdrops = Yes)
- **Options:** Same as Main Package

#### Field 40: Second Pack Total (Hidden Calculation)
- **Type:** Number Input (Readonly)
- **Behavior:** Auto-calculated from Second Package selection

#### Field 41: Third Pack Selection (Conditional)
**IF Number of Children = Three:**

- **Field:** "Third Pack Selection"
- **Type:** Radio Group
- **Options:** Same as Main Package

#### Field 42: Third Pack Total (Hidden Calculation)
- **Type:** Number Input (Readonly)

#### Field 43: Class Picture Size Selection
- **Field:** "Class Picture Size Selection"
- **Type:** Radio Group
- **Options:**
  - Print 8x10 - $20
  - Print 11x14 - $24
  - Print Panorama 5x20 - $40
- **Behavior:** Adds to total

#### Field 44: Class Pic (Panoramic) Total (Hidden Calculation)
- **Type:** Number Input (Readonly)

---

### Page 6: Enhance Your Pack

#### Field 45: Pose Perfection Service
- **Field:** "Upgrade to Pose Perfection for Only $14?"
- **Type:** Radio Group
- **Default:** "No, Thanks"
- **Options:**
  - Yes, include the 2 extra poses
  - No, Thanks
- **Behavior:** 
  - Adds $14 for one child
  - Shows different pricing for multiple children

**IF Number of Children = Two:**
- **Field:** "Upgrade to Pose Perfection for both your children for Only $28?"
- **Options:**
  - Yes, include the 2 poses extras for each pack
  - No, Thanks

**IF Number of Children = Three:**
- **Field:** "Upgrade to Pose Perfection for each pack for your three children's pack for Only $42?"
- **Options:**
  - Yes, include the 2 poses extras for each pack
  - No, Thanks

#### Field 46: Pose Perfection Total (Hidden Calculation)
- **Type:** Number Input (Readonly)
- **Behavior:** 
  - $14 for one child
  - $28 for two children
  - $42 for three children

#### Field 47: Premium Retouch Service
- **Field:** "Would you like to include the Premium Retouch Service? $12"
- **Type:** Radio Group
- **Default:** "No, Thanks"
- **Options:**
  - Yes, please
  - No, Thanks
- **Behavior:** Adds $12

#### Field 48: Retouch Specification
- **Field:** "Specify what you would like to have retouched?"
- **Type:** Text Input
- **Required:** No (but appears when Premium Retouch = Yes)
- **Behavior:** Conditional on Field 47

#### Field 49: Premium Retouch Total (Hidden Calculation)
- **Type:** Number Input (Readonly)
- **Behavior:** Shows $12 if selected

#### Field 50: Add-Ons Selection
- **Field:** "Do you wish to add any of the following extras?"
- **Type:** Checkbox Group
- **Options:**
  - Extra Smiles - Two 5x7 prints ($19)
  - Big Moments - One 8x10 print ($19)
  - Class Picture size 8x10 ($20)
  - Digital Add-On ($20)
  - Memory Mug ($22)
- **Behavior:** Each adds to total

#### Field 51-55: Add-On Totals (Hidden Calculations)
- Extra Smiles Total
- Big Moments Total
- Class Picture Total
- Digital Add-On Total
- Memory Mug Total

#### Field 56: Comments/Instructions
- **Field:** "Share your comments, suggestions or instructions"
- **Type:** Textarea
- **Placeholder:** "Type here... (For example, is there anything in specific that makes your child smile?)"
- **Required:** No

---

### Page 7: Shipping

#### Field 57: Shipping Method
- **Field:** "What type of shipping method would you prefer to have?"
- **Type:** Radio Group
- **Default:** "Free Shipping to the school - 3 to 4 weeks after the session."
- **Options:**
  - Free Shipping to the school - 3 to 4 weeks after the session.
  - Home Shipping - 6 to 10 business days after selecting you images - $7
- **Behavior:** Sets shipping cost

#### Field 58: Shipping Total (Hidden Calculation)
- **Type:** Number Input (Readonly)
- **Default Value:** 0
- **Behavior:** Shows $7 if Home Shipping selected

#### Field 59: Shipping Address (Conditional)
**IF Shipping Method = Home Shipping:**

- **Field:** "Please fill out your shipping address"
- **Type:** Address Fields (Multiple)
- **Required:** Yes (when Home Shipping selected)
- **Fields:**
  - Street Address * (Text Input)
  - Street Address Line 2 (Text Input, Optional)
  - City * (Text Input)
  - State * (Dropdown - All 50 US States + DC)
  - Zip Code * (Text Input)

---

### Page 8: Ordering Preferences

#### Field 60: Image Selection Preference
- **Field:** "If the 5-day period ends without a selection, would you like us to select your images on your behalf to complete your order? *"
- **Type:** Radio Group
- **Required:** Yes
- **Options:**
  - Yes, please select the images for me if I don't make a selection within 5 days.
  - No, and I understand that I am responsible for selecting the images and handling shipping fees if I miss the 5-day deadline.

#### Field 61: Time Slot Selection
- **Field:** "Select from our available time slot"
- **Type:** Appointment/Date-Time Picker
- **Behavior:** 
  - Calendar widget
  - Shows available dates
  - Time zone: Pacific/Easter (GMT-05:00)
  - Selected Date example: "10/31/2025"
  - 30-minute time slots
  - Maximum 4 participants per slot
- **Integration:** JotForm Appointment Field
- **API Endpoint:** `https://eu-submit.jotform.com/server.php?action=getAppointments&formID=230024885645660&timezone=Pacific%2FEaster%20(GMT-05%3A00)`

#### Field 62: Terms & Conditions Notice
- **Field:** Terms and Conditions for Picture Day Time Slot Booking
- **Type:** Information Text
- **Content:** Detailed terms about:
  - Booking confirmation
  - Time slot duration (30 minutes)
  - Participants per slot (4)
  - Rescheduling (48 hours advance)
  - Cancellations (24 hours advance)
  - No-show policy
  - Preparation requirements
  - Staff allocation
  - Liability
  - Consent and image usage
  - Contact information

---

### Page 9: Order Summary

#### Field 63: Order Summary Table
- **Type:** Table Display
- **Columns:**
  - Item
  - Description
  - Price
- **Sections:**
  - Selected Package
  - Services
  - Add-Ons
  - Additional Information

#### Field 64: Coupon Code
- **Field:** "Have a discount code? Enter it below: ⬇️"
- **Type:** Text Input
- **Required:** No
- **Behavior:** Validates and applies discount

#### Field 65: Discount Amount (Hidden Calculation)
- **Type:** Number Input (Readonly)
- **Behavior:** Shows discount if coupon valid

#### Field 66: Total Amount Calculation (Hidden)
- **Type:** Text Input (Readonly)
- **Default Value:** "0.00"
- **Behavior:** Sum of all items before discount

#### Field 67: Final Amount Due (Hidden Calculation)
- **Type:** Text Input (Readonly)
- **Default Value:** "0"
- **Behavior:** Total - Discount + Shipping

---

### Page 10: Authorization & Payment

#### Field 68: Photo Session Participation Agreement
- **Type:** Terms & Conditions Widget
- **Content:** Legal text about:
  - Lawful use of photographs
  - Permission to photograph child
  - Commercial copyright retention
  - COPPA compliance
  - Email consent
  - Terms & Conditions link
  - Cancellation & Refund Policy link

#### Field 69: Picture Day Authorization
- **Field:** "Picture Day Authorization"
- **Type:** Radio Group
- **Required:** Yes
- **Options:**
  - I agree with the statement above.

#### Field 70: Signature *
- **Field:** "Signature ✍️ *"
- **Type:** Signature Pad (jSignature)
- **Required:** Yes
- **Behavior:** Canvas-based signature capture
- **Button:** "Clear"

#### Field 71: Email Newsletter Opt-in
- **Field:** "Would you like to hear from us?"
- **Type:** Checkbox
- **Options:**
  - I'd like to receive email notifications from time to time. (No spam)
- **Required:** No

#### Field 72: Cancellation Policy Agreement
- **Type:** Terms & Conditions Widget
- **Content:** Link to Cancellation & Refund Policy
- **Text:** "I agree to the {Cancellation & Refund Policy}."

#### Field 73: Payment
- **Type:** Stripe Payment Element (Embedded iframe)
- **Integration:** Stripe Elements API
- **Stripe Public Key:** `pk_live_519Zq3sJCH12BI1V2ZwYKITN8nUOUqOFrv4d8BxwfOl97JeqgU2n9seklqKy7xmc730J6Bphl1tRFC7nYF1aWfdGN00hmJB4yG5`
- **Payment Methods:** Card, Link
- **Fields:**
  - Credit Card First Name (Text Input)
  - Credit Card Last Name (Text Input)
  - Credit Card Number (Stripe secure field)
  - Security Code (Stripe secure field)
  - Card Expiration (Stripe secure field)
- **Currency:** USD
- **Amount:** Calculated from Final Amount Due

---

## Conditional Logic Mapping

### Logic Rule 1: School Selection → Project Configuration
```
IF School Selected:
  THEN:
    - Set Registration Deadline (auto-populated)
    - Set Has Two Backdrops? (Yes/No)
    - Set Assigned Project Name
    - Show appropriate backdrop selection field(s)
```

### Logic Rule 2: Has Two Backdrops → Backdrop Selection
```
IF Has Two Backdrops = Yes:
  THEN:
    - Show backdrop selection with multiple options
    - Show warning: "You can only choose one backdrop per registration"
    - IF Two backdrops selected → Require Second Package

IF Has Two Backdrops = No:
  THEN:
    - Show single backdrop selection based on project type
```

### Logic Rule 3: Number of Children → Child Fields
```
IF Number of Children = One (1):
  THEN:
    - Show Child 1 fields (all required)
    - Hide Child 2 fields
    - Hide Child 3 fields

IF Number of Children = Two (2):
  THEN:
    - Show Child 1 fields (all required)
    - Show Child 2 fields (all required)
    - Hide Child 3 fields

IF Number of Children = Three (3):
  THEN:
    - Show Child 1 fields (all required)
    - Show Child 2 fields (all required)
    - Show Child 3 fields (all required)
```

### Logic Rule 4: Sibling Special → Sibling Packages
```
IF Sibling Special = Yes:
  THEN:
    - Show "Select Your Siblings Package" field
    - Show package pose distribution field
    - IF Number of Children = Three:
      THEN:
        - Show "Select Your Second Siblings Package" field
    - Add $5 to total

IF Sibling Special = No:
  THEN:
    - Hide sibling package fields
    - Hide package pose distribution field
```

### Logic Rule 5: Has Two Backdrops → Second Package Required
```
IF Has Two Backdrops = Yes:
  THEN:
    - Show notice: "The second Pack is mandatory since you have selected two backdrops"
    - Show "Select your second Package" field (Required)
    - Require second package selection

IF Has Two Backdrops = No:
  THEN:
    - Hide second package field
```

### Logic Rule 6: Number of Children → Third Package
```
IF Number of Children = Three:
  THEN:
    - Show "Third Pack Selection" field

IF Number of Children < Three:
  THEN:
    - Hide third package field
```

### Logic Rule 7: Pose Perfection Pricing by Number of Children
```
IF Pose Perfection = Yes AND Number of Children = One:
  THEN:
    - Set Pose Perfection Total = $14

IF Pose Perfection = Yes AND Number of Children = Two:
  THEN:
    - Show field: "Upgrade to Pose Perfection for both your children for Only $28?"
    - Set Pose Perfection Total = $28

IF Pose Perfection = Yes AND Number of Children = Three:
  THEN:
    - Show field: "Upgrade to Pose Perfection for each pack for your three children's pack for Only $42?"
    - Set Pose Perfection Total = $42
```

### Logic Rule 8: Premium Retouch → Specification Field
```
IF Premium Retouch = Yes:
  THEN:
    - Show "Specify what you would like to have retouched?" field

IF Premium Retouch = No:
  THEN:
    - Hide specification field
```

### Logic Rule 9: Shipping Method → Address Fields
```
IF Shipping Method = Home Shipping:
  THEN:
    - Show shipping address fields (all required)
    - Set Shipping Total = $7

IF Shipping Method = Free Shipping to School:
  THEN:
    - Hide shipping address fields
    - Set Shipping Total = $0
```

### Logic Rule 10: Package Selection → 4 Poses Upgrade Availability
```
IF Main Package Selected:
  THEN:
    - Show "Would you like to upgrade to 4 Poses Digital for only $10?" field
    - IF Yes: Add $10 to total
```

### Logic Rule 11: Registration Type → Package Availability
```
IF Registration Type = "Prepay and Unlock All Benefits":
  THEN:
    - Show all package options
    - Enable payment at checkout

IF Registration Type = "Register without Pre-Paying":
  THEN:
    - Show all package options
    - Disable payment (register only)
```

---

## Pricing & Calculation Logic

### Base Package Prices

| Package Name | Price | Poses |
|-------------|-------|-------|
| Single Smile | $48 | 1 |
| Popular Pair | $65 | 2 |
| Picture Perfect | $79 | 3 |
| Digital Duo | $55 | 2 (digital only) |
| Triple Treat | $65 | 3 |
| Fantastic Four | $124 | 4 |

### Service Prices

| Service | Price | Notes |
|---------|-------|-------|
| 4 Poses Digital Upgrade | $10 | Adds 2 additional digital poses |
| Pose Perfection (1 child) | $14 | 2 extra poses to choose from |
| Pose Perfection (2 children) | $28 | 2 extra poses per child |
| Pose Perfection (3 children) | $42 | 2 extra poses per child |
| Premium Retouch | $12 | Per image retouching |
| Sibling Special | $5 | Extra child fee for single package |

### Add-On Prices

| Add-On | Price |
|--------|-------|
| Extra Smiles - Two 5x7 prints | $19 |
| Big Moments - One 8x10 print | $19 |
| Class Picture size 8x10 | $20 |
| Digital Add-On | $20 |
| Memory Mug | $22 |

### Class Picture Sizes

| Size | Price |
|------|-------|
| Print 8x10 | $20 |
| Print 11x14 | $24 |
| Print Panorama 5x20 | $40 |

### Shipping Prices

| Method | Price | Timeline |
|--------|-------|----------|
| Free Shipping to School | $0 | 3-4 weeks after session |
| Home Shipping | $7 | 6-10 business days after image selection |

### Calculation Formula

```
Subtotal = 
  Main Package Price +
  (IF Second Package Selected: Second Package Price) +
  (IF Third Package Selected: Third Package Price) +
  (IF Sibling Special: $5) +
  (IF 4 Poses Upgrade: $10) +
  (IF Pose Perfection: $14/$28/$42 based on children count) +
  (IF Premium Retouch: $12) +
  (Sum of selected Add-Ons) +
  (Class Picture Size Price if selected)

Shipping = 
  IF Home Shipping: $7
  ELSE: $0

Total Amount Calculation = Subtotal

Discount Applied = (IF Valid Coupon: Discount Amount)

Final Amount Due = Total Amount Calculation - Discount Applied + Shipping
```

---

## Package Options

### Main Packages

1. **Single Smile - $48**
   - 1 pose
   - Prints included (varies by package)

2. **Popular Pair - $65**
   - 2 poses
   - Prints included

3. **Picture Perfect - $79**
   - 3 poses
   - Prints included

4. **Digital Duo - $55**
   - 2 poses
   - Digital downloads only

5. **Triple Treat - $65**
   - 3 poses
   - Prints included

6. **Fantastic Four - $124**
   - 4 poses
   - Prints included

### Sibling Packages (Same as Main Packages)

Used when Sibling Special is selected ($5 additional fee).

---

## Backdrop Options

Backdrop options are conditional based on:
1. School selection
2. Project type (Winter, Spring, Graduation, etc.)
3. Has Two Backdrops flag

### Available Backdrop Types:

- **Spring**
- **Graduation**
- **School Pictures**
- **Winter**
- **Christmas**
- **Back To School**
- **Fall**

### Backdrop Selection Rules:

1. **Single Backdrop Schools:**
   - User selects one backdrop from available options
   - One package required

2. **Two Backdrop Schools:**
   - User can select one backdrop per registration
   - Warning displayed: "You can only choose one backdrop per registration"
   - If user wants both backdrops, must submit separate registration
   - IF two backdrops selected in separate registrations → Second Package becomes mandatory

---

## Payment Integration

### Stripe Integration

- **Provider:** Stripe
- **Integration Type:** Stripe Elements (Embedded)
- **Public Key:** `pk_live_519Zq3sJCH12BI1V2ZwYKITN8nUOUqOFrv4d8BxwfOl97JeqgU2n9seklqKy7xmc730J6Bphl1tRFC7nYF1aWfdGN00hmJB4yG5`
- **Payment Methods:** Credit Card, Stripe Link
- **Currency:** USD
- **API Endpoints:**
  - `https://api.stripe.com/v1/elements/sessions`
  - `https://r.stripe.com/b` (tracking)

### Payment Flow:

1. User completes all form fields
2. Order summary displays final amount
3. User accepts terms and conditions
4. User provides signature
5. Stripe Payment Element loads (iframe)
6. User enters payment details
7. Form submits to JotForm
8. JotForm processes payment via Stripe
9. Confirmation sent

---

## Technical Integrations

### Third-Party Services:

1. **JotForm**
   - Form hosting and data collection
   - Form ID: 230024885645660
   - API: `https://eu-api.jotform.com`
   - Submit endpoint: `https://eu-submit.jotform.com/server.php`

2. **Stripe**
   - Payment processing
   - Stripe Elements for secure card input
   - Deferred intent payment mode

3. **Google reCAPTCHA**
   - Bot protection
   - Site Key: `6LcG3CgUAAAAAGOEEqiYhmrAm6mt3BDRhTrxWCKb`
   - Version: v2 (invisible)

4. **JotForm Appointment Field**
   - Time slot booking
   - Calendar widget
   - Timezone: Pacific/Easter (GMT-05:00)

5. **jSignature**
   - Signature capture
   - Canvas-based drawing

### JavaScript Libraries:

- jQuery 3.7.1
- JotForm Forms JS
- Stripe.js v3
- Math Processor (for calculations)
- Masked Input (for phone formatting)
- Smooth Scroll

### CSS Frameworks:

- JotForm default theme
- Custom theme CSS
- Stripe Elements CSS

### Fonts:

- Nunito (Light, Regular, Bold, Italic)
- Playfair Display (SemiBold)
- Inter (Regular, Medium)

---

## Brand Guidelines

### Colors (To be extracted from CSS):
- Primary brand colors need to be extracted from stylesheets
- Check: `https://cdn.jotfor.ms/themes/CSS/548b1325700cc48d318b4567.css`

### Typography:
- **Headings:** Playfair Display (SemiBold)
- **Body:** Nunito (Regular)
- **UI Elements:** Inter (Regular, Medium)

### Logo:
- **Source:** `https://eu-files.jotform.com/jufs/The_info820/form_files/LOGO_LOGO%20copia%20128.66b5d4d5ca8165.55339974.png`

### Images Used:
- Package images (Single Smile, Popular Pair, etc.)
- Add-on images
- Service images (Pose Perfection, Premium Retouch)
- Shipping image

---

## Next Steps for Laravel Implementation

1. **Database Schema:**
   - Schools table (149 schools)
   - Projects table (project names, deadlines, backdrop configs)
   - Registrations table
   - Children table
   - Packages table
   - Orders table
   - Payments table

2. **Form Builder:**
   - Multi-step wizard component
   - Conditional field rendering
   - Dynamic calculations

3. **Payment Integration:**
   - Stripe Elements implementation
   - Payment intent creation
   - Webhook handling

4. **Business Logic:**
   - Pricing calculator
   - Package availability rules
   - Time slot booking system

5. **Email System:**
   - Order confirmation emails
   - Gallery ready notifications
   - Reminder emails

---

**END OF INITIAL ANALYSIS**

*This document will be updated as we continue exploring the form interactively to expose all conditional logic paths.*

