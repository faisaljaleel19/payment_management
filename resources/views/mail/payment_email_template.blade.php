<x-mail::message>
<table style="background-color: #f5f5f5;" class="table">
<tr>
<td><img src="https://resource.moreideas.ae/payment_mi/public/assets/img/moreideas-logo-color.png" alt="More Ideas Logo" class="img-fluid" width="20%">&nbsp;&nbsp;&nbsp;&nbsp;<img src="https://resource.moreideas.ae/payment_mi/public/assets/img/byjus_new.png" alt="More Ideas Logo" width="20%"></td>
</tr>
</table>
<div style="padding: 20px;">
<p style="font-size: 0.8em">{{ $customer_name }},</p>
<p style="font-size: 0.8em; text-align: justify;">Thank you for your order.</p>
<p style="font-size: 0.8em; text-align: justify;">If you have questions about your order, you can email us at support.byjus@moreideas.ae .</p>
<h2>Your Order #{{ $order_no }}</h2>
<p style="font-size: 0.8em">Placed on {{ $order_date }}</p>
<table style="width: 100%" class="table" cellspacing="20">
<tr>
<th style="text-align: left">Billing Info</th>
<th style="text-align: left">Shipping Info</th>
</tr>
<tr>
<td>
<span style="font-size: 0.8em">{{ $customer_name }}</span><br>
<span style="font-size: 0.8em">{{ $street_address1 }}</span><br>
<span style="font-size: 0.8em">{{ $street_address2 }}</span><br>
<span style="font-size: 0.8em">{{ $street_address3 }}</span><br>
<span style="font-size: 0.8em">{{ $city.', '.$state.', '.$zip_code }}</span><br>
<span style="font-size: 0.8em">{{ $country }}</span><br>
<span style="font-size: 0.8em">T: {{ $phone_no }}</span><br>
</td>
<td>
<span style="font-size: 0.8em">{{ $customer_name }}</span><br>
<span style="font-size: 0.8em">{{ $street_address1 }}</span><br>
<span style="font-size: 0.8em">{{ $street_address2 }}</span><br>
<span style="font-size: 0.8em">{{ $street_address3 }}</span><br>
<span style="font-size: 0.8em">{{ $city.', '.$state.', '.$zip_code }}</span><br>
<span style="font-size: 0.8em">{{ $country }}</span><br>
<span style="font-size: 0.8em">T: {{ $phone_no }}</span><br>
</td>
</tr>
<tr>
<th style="text-align: left">Payment Method</th>
</tr>
<tr>
<td><span style="font-size: 0.8em">Payfort Payment Gateway</span></td>
</tr>
</table>
<x-mail::button :url="$payment_link">Pay</x-mail::button>
</div>
</x-mail::message>
