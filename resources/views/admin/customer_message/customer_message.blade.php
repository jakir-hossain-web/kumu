@extends('layouts.dashboard')

<style>
    .btn_design{
        padding: 5px 15px;
        border-radius: 10px;
        border: none;
    }

    .error_message{
        font-size: 35px;
        text-align: center;
        padding: 10px 0;
    }

    .processing{
        position: fixed;
        top: 0;
        left: 0;
        height: 100vh;
        width: 100vw;
        background: rgba(0, 0, 0, 0.452);
        z-index: 999;
        color: #ffe600;
    }
    .sending_message_gif{
        position: fixed;
        top: 0;
        left: 0;
        height: 100vh;
        width: 100vw;
        background: rgba(0, 0, 0, 0.85);
        z-index: 999;
    }
    .sending_message_gif h1{
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        color: #fff;
    }
</style>

@section('content')
<div class="page-titles">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
        <li class="breadcrumb-item active"><a href="javascript:void(0)">Customer Message</a></li>
    </ol>
</div>

<div class="row">
    <div class="sending_message_gif d-none">
        <h1><span></span> Message is sending...</h1>
    </div>
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header bg-primary">
                <h4 style="color: #fff">Customer Message</h4>
            </div>
            <div class="card-body">
                <table class="table table-striped">
                    <tr>
                        <th>SL</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Mobile</th>
                        <th style="width: 25%">Message</th>
                        <th class="text-center" style="width: 25%">Our Reply</th>
                        <th class="text-center">Reply</th>
                    </tr>

                    @foreach ($messages as $key=>$message) 
                        @if ($message->your_reply == null)
                            <tr style="color: #000">
                                <form action="{{route('reply_customer_message')}}" method="POST">
                                    @csrf
                                    <td>{{$key+1}}</td>
                                    <td>{{$message->name}}</td>
                                    <td>{{$message->email}}</td>
                                    <td>{{$message->mobile}}</td>
                                    <td style="width: 25%">{{$message->message}}</td>
                                    <td style="width: 25%; padding: 12px 0">
                                        <div>
                                            <input type="hidden" name="message_id" value="{{$message->id}}">
                                            <input type="hidden" name="customer_email_address" value="{{$message->email}}">
                                            <input type="hidden" name="customer_message" value="{{$message->message}}">
                                            {{-- <textarea style="color:#646464; border: 1px solid #000;" class="form-control" name="reply_message"></textarea> --}}
                                            <textarea readonly style="color:#646464; border: 1px solid #c1c1c1; cursor: not-allowed;" class="form-control" name="reply_message" title="Click The Reply Button First" placeholder="Click The Reply Button First"></textarea>
                                            {{-- error message --}}
                                            <div class="text-center reply_message_err"></div>
                                        </div>                                      
                                    </td>
                                    <td>
                                        <div>
                                            {{-- <button type="submit" class="btn_design btn-primary reply_message_send_btn">Reply</button> --}}
                                            <button type="button" class="btn_design btn-primary reply_message_btn">Reply</button>
                                            <button type="submit" class="btn_design btn-success d-none reply_message_send_btn">Send</button>                                    
                                        </div>
                                    </td>
                                </form>
                            </tr> 

                            @else
                            <tr>
                                <form action="" method="POST">
                                    @csrf
                                    <td>{{$key+1}}</td>
                                    <td>{{$message->name}}</td>
                                    <td>{{$message->email}}</td>
                                    <td>{{$message->mobile}}</td>
                                    <td style="width: 25%">{{$message->message}}</td>
                                    <td style="width: 25%; padding: 12px 0">
                                        {{$message->your_reply}}
                                    </td>
                                    <td>
                                        <button style="cursor: default" type="button" class="btn_design btn-danger">Sended</button>
                                    </td>
                                </form>
                            </tr> 
                        @endif
                    @endforeach
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@section('footer_script')

    <script>
        $(document).ready(function() {
            $('.reply_message_send_btn').click(function(event) {
                
                var value = $(this).closest('tr').find('textarea').val();
                var length = value.length; 

                if(length == ''){
                    $(this).closest('tr').find('textarea').css('border', '3px solid red');
                    $(this).closest('tr').find('textarea').focus();
                    $(this).closest('tr').find('.reply_message_err').html('Type Your Message First!');
                    $(this).closest('tr').find('.reply_message_err').css('color', 'red');
                    event.preventDefault(); // Prevent the default form submission
                }
                else if(length <20){
                    $(this).closest('tr').find('textarea').css('border', '3px solid red');
                    $(this).closest('tr').find('textarea').focus();
                    $(this).closest('tr').find('.reply_message_err').html('Minimum 20 character Required!');
                    $(this).closest('tr').find('.reply_message_err').css('color', 'red');
                    event.preventDefault(); // Prevent the default form submission
                }
                else{
                    $(this).closest('tr').find('textarea').css('border', '3px solid green');
                    $(this).closest('tr').find('.reply_message_err').html('Sending The Message.....');
                    $(this).closest('tr').find('.reply_message_err').css('color', 'green');
                    $('.sending_message_gif').removeClass('d-none');
                    $(this).closest('form').submit();
                }
            });
        });
    </script>

    <script>
        $('.reply_message_btn').click(function(){
            $(this).closest('tr').find('.reply_message_send_btn').removeClass('d-none');
            $(this).closest('tr').find('.reply_message_btn').addClass('d-none');
            $(this).closest('tr').find('textarea').removeAttr('readonly');
            $(this).closest('tr').find('textarea').removeAttr('placeholder');
            $(this).closest('tr').find('textarea').removeAttr('title');
            $(this).closest('tr').find('textarea').focus();
            $(this).closest('tr').find('textarea').css('border', '3px solid #7a7a7a');
            $(this).closest('tr').find('textarea').css('background', '#f2f2f2');
            $(this).closest('tr').find('textarea').css('cursor', 'text');
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