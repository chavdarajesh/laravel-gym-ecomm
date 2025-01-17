sub categoiry 
name 
image 
description 
-------------------------
Category 
name 
image 
description 
sub categoiry multiple
-------------------------
Barnd 
name 
image 
description 
Category multiple 
subcaregory multiple
-----------------------------
size
name 
-------------------------
FLower
name
--------------------------
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
--------------------------
product review
rating star 
comment 
name 
email 



--------PAYID-M57LDDQ92318331GD5449824=====PayPal\Api\Payment Object ( [_propMap:PayPal\Common\PayPalModel:private] => Array ( [id] => PAYID-M57LDDQ92318331GD5449824 [intent] => sale [state] => approved [cart] => 62D71738RK9785605 [payer] => PayPal\Api\Payer Object ( [_propMap:PayPal\Common\PayPalModel:private] => Array ( [payment_method] => paypal [status] => VERIFIED [payer_info] => PayPal\Api\PayerInfo Object ( [_propMap:PayPal\Common\PayPalModel:private] => Array ( [email] => sb-j66pk36109901@business.example.com [first_name] => John [last_name] => Doe [payer_id] => DFDTXA39F89N4 [shipping_address] => PayPal\Api\ShippingAddress Object ( [_propMap:PayPal\Common\PayPalModel:private] => Array ( [recipient_name] => John Doe [line1] => 1 Main St [city] => San Jose [state] => CA [postal_code] => 95131 [country_code] => US ) ) [country_code] => US [business_name] => Test Store ) ) ) ) [transactions] => Array ( [0] => PayPal\Api\Transaction Object ( [_propMap:PayPal\Common\PayPalModel:private] => Array ( [amount] => PayPal\Api\Amount Object ( [_propMap:PayPal\Common\PayPalModel:private] => Array ( [total] => 1000.00 [currency] => USD [details] => PayPal\Api\Details Object ( [_propMap:PayPal\Common\PayPalModel:private] => Array ( [subtotal] => 1000.00 [shipping] => 0.00 [insurance] => 0.00 [handling_fee] => 0.00 [shipping_discount] => 0.00 [discount] => 0.00 ) ) ) ) [payee] => PayPal\Api\Payee Object ( [_propMap:PayPal\Common\PayPalModel:private] => Array ( [merchant_id] => 88YNJH2P5D7GN [email] => sb-i3jac20305813@business.example.com ) ) [description] => Your transaction description [item_list] => PayPal\Api\ItemList Object ( [_propMap:PayPal\Common\PayPalModel:private] => Array ( [items] => Array ( [0] => PayPal\Api\Item Object ( [_propMap:PayPal\Common\PayPalModel:private] => Array ( [name] => Test 1 [price] => 1000.00 [currency] => USD [tax] => 0.00 [quantity] => 1 [image_url] => ) ) ) [shipping_address] => PayPal\Api\ShippingAddress Object ( [_propMap:PayPal\Common\PayPalModel:private] => Array ( [recipient_name] => John Doe [line1] => 1 Main St [city] => San Jose [state] => CA [postal_code] => 95131 [country_code] => US ) ) ) ) [related_resources] => Array ( [0] => PayPal\Api\RelatedResources Object ( [_propMap:PayPal\Common\PayPalModel:private] => Array ( [sale] => PayPal\Api\Sale Object ( [_propMap:PayPal\Common\PayPalModel:private] => Array ( [id] => 23J48932AJ5040133 [state] => completed [amount] => PayPal\Api\Amount Object ( [_propMap:PayPal\Common\PayPalModel:private] => Array ( [total] => 1000.00 [currency] => USD [details] => PayPal\Api\Details Object ( [_propMap:PayPal\Common\PayPalModel:private] => Array ( [subtotal] => 1000.00 [shipping] => 0.00 [insurance] => 0.00 [handling_fee] => 0.00 [shipping_discount] => 0.00 [discount] => 0.00 ) ) ) ) [payment_mode] => INSTANT_TRANSFER [protection_eligibility] => ELIGIBLE [protection_eligibility_type] => ITEM_NOT_RECEIVED_ELIGIBLE,UNAUTHORIZED_PAYMENT_ELIGIBLE [transaction_fee] => PayPal\Api\Currency Object ( [_propMap:PayPal\Common\PayPalModel:private] => Array ( [value] => 46.37 [currency] => USD ) ) [parent_payment] => PAYID-M57LDDQ92318331GD5449824 [create_time] => 2025-01-08T17:10:52Z [update_time] => 2025-01-08T17:10:52Z [links] => Array ( [0] => PayPal\Api\Links Object ( [_propMap:PayPal\Common\PayPalModel:private] => Array ( [href] => https://api.sandbox.paypal.com/v1/payments/sale/23J48932AJ5040133 [rel] => self [method] => GET ) ) [1] => PayPal\Api\Links Object ( [_propMap:PayPal\Common\PayPalModel:private] => Array ( [href] => https://api.sandbox.paypal.com/v1/payments/sale/23J48932AJ5040133/refund [rel] => refund [method] => POST ) ) [2] => PayPal\Api\Links Object ( [_propMap:PayPal\Common\PayPalModel:private] => Array ( [href] => https://api.sandbox.paypal.com/v1/payments/payment/PAYID-M57LDDQ92318331GD5449824 [rel] => parent_payment [method] => GET ) ) ) ) ) ) ) ) ) ) ) [redirect_urls] => PayPal\Api\RedirectUrls Object ( [_propMap:PayPal\Common\PayPalModel:private] => Array ( [return_url] => http://localhost/laravel/laravel-gym/paypal?paymentId=PAYID-M57LDDQ92318331GD5449824 [cancel_url] => http://localhost/laravel/laravel-gym/paypal ) ) [create_time] => 2025-01-08T17:10:38Z [update_time] => 2025-01-08T17:10:52Z [links] => Array ( [0] => PayPal\Api\Links Object ( [_propMap:PayPal\Common\PayPalModel:private] => Array ( [href] => https://api.sandbox.paypal.com/v1/payments/payment/PAYID-M57LDDQ92318331GD5449824 [rel] => self [method] => GET ) ) ) [failed_transactions] => Array ( ) ) )



PayPal\Api\Refund Object ( [_propMap:PayPal\Common\PayPalModel:private] => Array ( [id] => 6FV24114X4977630X [state] => completed [amount] => PayPal\Api\Amount Object ( [_propMap:PayPal\Common\PayPalModel:private] => Array ( [total] => 990.00 [currency] => USD ) ) [reason] => Sale refund [refund_from_received_amount] => Array ( [value] => 944.44 [currency] => USD ) [refund_from_transaction_fee] => Array ( [value] => 45.56 [currency] => USD ) [total_refunded_amount] => Array ( [value] => 1000.00 [currency] => USD ) [parent_payment] => PAYID-M57LDDQ92318331GD5449824 [sale_id] => 23J48932AJ5040133 [create_time] => 2025-01-08T17:16:27Z [update_time] => 2025-01-08T17:16:27Z [links] => Array ( [0] => PayPal\Api\Links Object ( [_propMap:PayPal\Common\PayPalModel:private] => Array ( [href] => https://api.sandbox.paypal.com/v1/payments/refund/6FV24114X4977630X [rel] => self [method] => GET ) ) [1] => PayPal\Api\Links Object ( [_propMap:PayPal\Common\PayPalModel:private] => Array ( [href] => https://api.sandbox.paypal.com/v1/payments/payment/PAYID-M57LDDQ92318331GD5449824 [rel] => parent_payment [method] => GET ) ) [2] => PayPal\Api\Links Object ( [_propMap:PayPal\Common\PayPalModel:private] => Array ( [href] => https://api.sandbox.paypal.com/v1/payments/sale/23J48932AJ5040133 [rel] => sale [method] => GET ) ) ) ) )
