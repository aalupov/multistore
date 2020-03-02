Hello <i>{{ $addBuisnessMailSend->receiver_name }}</i>,

<p>This is request to add the new store </p>

<p><strong>Title</strong>: {{ $addBuisnessMailSend->sender_message['store_title'] }}</p>
<p><strong>Description</strong>: {{ $addBuisnessMailSend->sender_message['store_description'] }}</p>
<p><strong>Email</strong>: {{ $addBuisnessMailSend->sender_message['store_email'] }}</p>
<p><strong>Phone</strong>: {{ $addBuisnessMailSend->sender_message['store_phone'] }}</p>
<p><strong>Address</strong>: {{ $addBuisnessMailSend->sender_message['store_address'] }}</p>
<p><strong>City</strong>: {{ $addBuisnessMailSend->sender_message['store_city'] }}</p>
<p><strong>Country</strong>: {{ $addBuisnessMailSend->sender_message['store_country'] }}</p>
<p><strong>State</strong>: {{ $addBuisnessMailSend->sender_message['store_state'] }}</p>
<p><strong>Zip Code</strong>: {{ $addBuisnessMailSend->sender_message['store_zip'] }}</p>
<p><strong>Lattitude</strong>: {{ $addBuisnessMailSend->sender_message['store_lat'] }}</p>
<p><strong>Lontitude</strong>: {{ $addBuisnessMailSend->sender_message['store_lon'] }}</p>
<p><strong>Image</strong>: {{ $addBuisnessMailSend->sender_message['store_picture'] }}</p>
<p><strong>Comment</strong>: {{ $addBuisnessMailSend->sender_message['store_comment'] }}</p>