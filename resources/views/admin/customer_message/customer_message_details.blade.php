@extends('layouts.dashboard')

<style>
    .customer_message p{
        border: 1px solid #c1c1c1;
        border-radius: 10px;
        padding: 20px 10px;
    }
    .customer_message_reply p{
        border: 1px solid #c1c1c1;
        border-radius: 10px;
        padding: 20px 10px;
    }
    .message_reply_textarea{
        width: 100% !important;
    }
    .sending_message_preloader{
        position: fixed;
        top: 0;
        left: 0;
        height: 100vh;
        width: 100vw;
        background: rgba(0, 0, 0, 0.85);
        z-index: 999;
    }
    .sending_message_preloader .sending_message_preloader_item{
        text-align: center;
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
    }
    .sending_message_preloader_item h1{
        color: #ffe600da;
        font-size: 35px;
    }
    .sending_message_preloader_item i{
        color: #ffe600;
        font-size: 65px;
    }
</style>

@section('content')
<div class="page-titles">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{route('customer_message')}}">Customer Message</a></li>
        <li class="breadcrumb-item active"><a href="javascript:void(0)">Customer Message Details</a></li>
    </ol>
</div>

<div class="row">
    <div class="sending_message_preloader d-none">
        <div class="sending_message_preloader_item">
            <h1><i class="fa fa-envelope"></i></h1>
            <h1>Message is sending...</h1>
        </div>
    </div>
    <div class="col-lg-8 m-auto">
        <div class="card">
            <div class="card-header bg-primary d-flex">
                <div class="customer_name">
                    <h3 style="color: #fff">{{$message_info->name}}</h3>
                </div>
                <div class="customer_email text-right">
                    <h6 style="color: #fff">{{$message_info->email}}</h6>
                    <h6 style="color: #fff">{{$message_info->created_at->format('d M,Y')}}</h6>
                </div>
            </div>
            <div class="card-body">
                <form action="{{route('reply_customer_message')}}" method="POST">
                    @csrf
                    <div class="customer_message">
                        <h5>Customer Message:</h5>
                        <p>{{$message_info->message}}</p>
                    </div> 
                    @if ($message_info->your_reply == null)
                        <div class="customer_message_reply">
                            <h5>Our Reply:</h5>
                            <p>
                                <input type="hidden" name="message_id" value="{{$message_info->id}}">
                                <input type="hidden" name="customer_email_address" value="{{$message_info->email}}">
                                <input type="hidden" name="customer_message" value="{{$message_info->message}}">

                                <textarea name="reply_message" class="form-control message_reply_textarea"></textarea>
                            </p>
                            <div class="text-center reply_message_err"></div>
                        </div>
                        <button type="submit" class="btn btn-primary d-block w-100 mt-3 reply_message_send_btn">Reply</button>
                        @else
                        <div class="customer_message_reply">
                            <h5>Our Reply:</h5>
                            <p>{{$message_info->your_reply}}</p>
                        </div>
                        <button type="button" style="cursor: default;" class="btn btn-danger message_sended_btn d-block w-100 mt-3">Replied</button>
                    @endif                      
                </form>                  
            </div>
        </div>
    </div>
</div>
@endsection

@section('footer_script')

    <script>
        $(document).ready(function() {
            $('.reply_message_send_btn').click(function(event) {

                var value = $('textarea').val();
                var length = value.length;

                if(length == ''){
                    $('textarea').css('border', '2px solid red');
                    $('textarea').focus();
                    $('.reply_message_err').html('Type Your Message First!');
                    $('.reply_message_err').css('color', 'red');
                    event.preventDefault(); // Prevent the default form submission
                }
                else if(length <20){
                    $('textarea').css('border', '2px solid red');
                    $('textarea').focus();
                    $('.reply_message_err').html('Minimum 20 character Required!');
                    $('.reply_message_err').css('color', 'red');
                    event.preventDefault(); // Prevent the default form submission
                }
                else{
                    $('textarea').css('border', '3px solid green');
                    $('.reply_message_err').html('Sending The Message.....');
                    $('.reply_message_err').css('color', 'green');
                    $('.sending_message_preloader').removeClass('d-none');
                    $(this).closest('form').submit();
                }
            });
        });
    </script>


    <script>
        $('.message_sended_btn').click(function(){
            Swal.fire({
                position: 'center',
                icon: 'warning',
                text: "Reply Message Already Sended!",
                showConfirmButton: false,
                background: '#01186d',
                color: '#d1d1d1',
                iconColor: '#d1d1d1'
                })
        });
    </script>

    @if (session('customer_message_reply_success'))
        <script>
            Swal.fire({
            position: 'center',
            icon: 'success',
            title: "{{session('customer_message_reply_success')}}",
            showConfirmButton: false,
            timer: 2000
            })
        </script>
    @endif

@endsection