<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        .visit_site{
            margin: 20px;
            text-align: center;
        }
        .visit_site a{
            background: #0B2A97;
            color: #fff;
            padding: 10px 25px;
            border-radius: 10px;
            text-decoration: none;
        }
    </style>
    
</head>
<body>
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

    <div class="visit_site"><a href="https://pikterit.com/">Visit Our Website</a></div>

    <a href="https://pikterit.com/"><img style="border-radius: 50%; width: 80px" src="https://i.postimg.cc/wTyd0LCj/channels4-profile.jpg" alt="logo"></a>
    <h2 style="line-height: 8px"> Pikter <span style="color: red">IT</span></h2>
    <p style="line-height: 8px">Shop No-309, Level-3</p>
    <p style="line-height: 8px">Multiplan Center</p>
    <p style="line-height: 8px">Elephent Road, Dhaka.</p>
    <p style="line-height: 8px"> <span>Email:</span> pikterit@gmail.com</p>
    <p style="line-height: 8px"> <span>Website:</span> https://pikterit.com</p>
    <p style="line-height: 8px">Contact: 01623486100 & 01623486101</p>
    <div>
        <span style="margin: 0 10px 0 0"><a href="https://www.facebook.com/pikteritltd"><img style="width: 28px" src="https://i.postimg.cc/Qt6zR201/facebook-174848.png" alt="facebook"></a></span>
        <span style="margin: 10px 10px 0 0"><a href="https://www.youtube.com/@pikterit"><img style="width: 33px" src="https://i.postimg.cc/k45S2KsW/youtube-1384060.png" alt="youtube"></a></span>
        <span style="0 10px 0 0"><a href="https://pikterit.com/"><img style="width: 28px" src="https://i.postimg.cc/MH2s2z1c/planet-earth-921490.png" alt="website"></a></span>
    </div>

</body>
</html>