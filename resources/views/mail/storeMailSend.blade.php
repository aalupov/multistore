Hello <i>{{ $storeMailSend->receiver_name }}</i>,
<p>This is email from the store contact page.</p>
 
<p><u>Message:</u></p>
 
<div>
<p>{{ $storeMailSend->sender_message }}</p>
</div>
 
<p><u>Sender Info:</u></p>
 
<div>
<p><b>Sender Name:</b>&nbsp;{{ $storeMailSend->sender_name  }}</p>
<p><b>Sender Email:</b>&nbsp;{{ $storeMailSend->sender_email  }}</p>
<p><b>Sender Phone:</b>&nbsp;{{ $storeMailSend->sender_phone  }}</p>
</div>
