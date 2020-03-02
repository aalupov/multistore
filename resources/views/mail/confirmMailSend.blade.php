Hello <i>{{ $confirmMailSend->receiver_name }}</i>,

<p>This is confirmation email to the order <strong><a href="{{ route('orderUser.show', $confirmMailSend->order_id) }}">#{{ $confirmMailSend->order_number }}</a></strong> </p>
 
<p>Thank you!</p>
 

