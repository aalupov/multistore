Hello {{ $storeMailSend->receiver_name }},

This is email from the store contact page.
 
Message:
 
{{ $storeMailSend->sender_message }}
 
Sender Info:
 
Sender Name: {{ $storeMailSend->sender_name  }}
Sender Email: {{ $storeMailSend->sender_email  }}
Sender Phone: {{ $storeMailSend->sender_phone  }}
