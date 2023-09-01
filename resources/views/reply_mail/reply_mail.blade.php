@php
    $customer_name = App\Models\CustomerMessage::where('id', $message_id)->first()->name;
    $customer_email = App\Models\CustomerMessage::where('id', $message_id)->first()->email;
    $customer_message = App\Models\CustomerMessage::where('id', $message_id)->first()->message;
    $message_date = App\Models\CustomerMessage::where('id', $message_id)->first()->created_at;
    $reply_message = App\Models\CustomerMessage::where('id', $message_id)->first()->your_reply;
@endphp
<h3>Hello <span>{{$customer_name}},</span></h3>
<p>We received one message/query/idea/complain from you <span>{{$customer_email}}</span> as on <span>{{$message_date->format('d M,Y')}}</span>.</p>
<p>Your message was-</p>
<p style="padding: 10px 30px">"{{$customer_message}}"</p>
<p>{{$reply_message}}</p>

<h4 style="padding-bottom: 15px">Thank you.</h4>
<h2>Pikter IT</h2>
<p>Shop No-309, Level-3</p>
<p>Multiplan Center</p>
<p>Elephent Road, Dhaka.</p>
