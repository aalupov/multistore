Hello <i>{{ $commentOrderMailSend->receiver_name }}</i>,

<p>This is new comment to the order <strong><a href="{{ route('orderUser.show', $commentOrderMailSend->order_id) }}">#{{ $commentOrderMailSend->order_number }}</a></strong> </p>

<p><strong>{{ $commentOrderMailSend->date }}</strong> - {{ $commentOrderMailSend->sender_message }}</p>
 
<p>Thank you!</p>