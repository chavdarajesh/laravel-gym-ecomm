sub categoiry
name
image
description

---

Category
name
image
description
sub categoiry multiple

---

Barnd
name
image
description
Category multiple
subcaregory multiple

---

size
name

---

FLower
name

---

product
name
coverimage
images multiple  
description
Barnd
Category from selected barnd
sub category from slectde category
size multiple
Flower multiple
price

---

product review
rating star
comment
name
email

---

payment_status → pending | processing | completed | failed | cancelled

order_status → pending | processing | delivered | cancelled

return_status -> 'none', 'requested', 'approved', 'rejected', 'refunded'

status → internal/global status (optional, could be avoided if redundant)

🛒 1. Order Created
'payment_status' => 'pending',
'order_status' => 'pending',
'status' => 'pending'

OrderStatus: 'Order Created' + 'Payment Pending'
==================================================================
User Uploads Payment Proof

'payment_status' => 'processing',
'order_status' => 'pending',

OrderStatus: 'Payment Processing'
==================================================================

Admin Accepts Payment

'payment_status' => 'completed',
'order_status' => 'processing', // Still not shipped/delivered

OrderStatus: 'Payment Completed' + 'Order Placed'

also make payment uplod as is verfied 1 
request_status == approve 

==================================================================


Admin Rejects Payment

'payment_status' => 'pending',
'order_status' => 'pending',

OrderStatus: 'Payment Failed' + 'Payment Pending'

also make payment uplod as is verfied 1 
request_status == approve 
==================================================================

Order Fulfillment
'order_status' => 'processing',

OrderStatus: 'Order Processing'

OrderStatus: 'Order Shipped'

'order_status' => 'completed',
OrderStatus: 'Order Delivered'
==================================================================
Order Cancelled

'payment_status' => 'completed', // if refund is optional
'order_status' => 'cancel',

OrderStatus: 'Cancelled By Admin'
==================================================================
Cancelled by User

'payment_status' => 'completed',
'order_status' => 'cancel',

OrderStatus: 'Order Cancelled'
==================================================================
Order delivered none completed completed Show “Request Refund” button

User submits refund
return_status - requested
New refund record created
==================================================================
Admin approves refund
return_status - approved
Admin initiates manual transfer
==================================================================
Admin completes refund
return_status - refunded
Status logs updated
==================================================================
Admin rejects refund
return_status - rejected
Show rejection reason to user
==================================================================

Schema::create('refund_requests', function (Blueprint $table) {
    $table->id();
    $table->foreignId('order_id');
    $table->dateTime('requested_at');
    $table->string('refund_ref_id')->nullable(); // Manual ref no. added by admin
    $table->string('photo_path')->nullable(); // Parcel photo
    $table->text('delivery_address');
    $table->enum('status', ['requested', 'approved', 'rejected', 'refunded'])->default('requested');
    $table->timestamps();
});

if ($order->payment_status == 'completed' && $order->order_status == 'completed' && $order->return_status == 'none') {
    // Show refund request button
}




baki 


show all payment upldoe in admin and link with order


show all refund req in admin and link with order 









