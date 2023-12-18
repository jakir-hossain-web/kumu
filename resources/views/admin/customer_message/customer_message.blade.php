@extends('layouts.dashboard')

<style>
    .btn_design{
        padding: 5px 15px;
        border-radius: 10px;
        border: none;
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
        <li class="breadcrumb-item active"><a href="javascript:void(0)">Customer Message</a></li>
    </ol>
</div>

<div class="row">
    <div class="sending_message_preloader d-none">
        <div class="sending_message_preloader_item">
            <h1><i class="fa fa-envelope"></i></h1>
            <h1>Message is sending...</h1>
        </div>
    </div>
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header bg-primary">
                <h4 style="color: #fff">Customer Message</h4>
            </div>
            <div class="card-body">
                <table class="table table-striped" id="messageTable">
                    <thead>
                        <tr>
                            <th>SL</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th style="width: 25%">Message</th>
                            <th class="text-center" style="width: 25%">Our Reply</th>
                            <th class="text-center">Reply</th>
                            <th>View</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($messages as $key=>$message) 
                            @if ($message->your_reply == null)
                                <tr style="color: #000">
                                    <form action="{{route('reply_customer_message')}}" method="POST">
                                        @csrf
                                        <td>{{$key+1}}</td>
                                        <td>{{$message->name}}</td>
                                        <td>{{$message->email}}</td>                                      
                                        <td style="width: 25%">{{$message->message}}</td>
                                        <td style="width: 25%; padding: 12px 0">
                                            <div>
                                                <input type="hidden" name="message_id" value="{{$message->id}}">
                                                <input type="hidden" name="customer_email_address" value="{{$message->email}}">
                                                <input type="hidden" name="customer_message" value="{{$message->message}}">
                                                <textarea readonly style="color:#646464; border: 1px solid #c1c1c1; cursor: not-allowed;" class="form-control reply_textarea" name="reply_message" title="Click The Reply Button First" placeholder="Click The Reply Button First"></textarea>
                                                {{-- error message --}}
                                                <div class="text-center reply_message_err"></div>
                                            </div>                                      
                                        </td>
                                        <td>
                                            <div>
                                                <button type="button" class="btn_design btn-primary reply_message_btn" data-custom-value="0">Reply</button>
                                                <button type="submit" class="btn_design btn-success d-none reply_message_send_btn">Send</button>                                    
                                            </div>
                                        </td>
                                        <td><button type="button" class="btn_design btn-secondary"><a href="{{route('customer_message_details', $message->id)}}" class="text-white">View</a></button></td>
                                    </form>
                                </tr> 

                                @else
                                <tr style="color: #6e6e6e">
                                    <form action="" method="POST">
                                        @csrf
                                        <td>{{$key+1}}</td>
                                        <td>{{$message->name}}</td>
                                        <td>{{$message->email}}</td>
                                        <td style="width: 25%">{{$message->message}}</td>
                                        <td style="width: 25%; padding: 12px 0">
                                            {{$message->your_reply}}
                                        </td>
                                        <td>
                                            <button style="cursor: default" type="button" class="btn_design btn-danger message_sended_btn">Replied</button>
                                        </td>
                                        <td><button type="button" class="btn_design btn-secondary"><a href="{{route('customer_message_details', $message->id)}}" class="text-white">View</a></button></td>
                                    </form>
                                </tr> 
                            @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@section('footer_script')

    <script>
        $(document).ready( function () {
            $('#messageTable').DataTable();
        } );
    </script>

    <script>
        $(document).ready(function() {
            $('.reply_message_send_btn').click(function(event) {
                
                var value = $(this).closest('tr').find('textarea').val();
                var length = value.length; 

                if(length == ''){
                    $(this).closest('tr').find('textarea').css('border', '2px solid red');
                    $(this).closest('tr').find('textarea').focus();
                    $(this).closest('tr').find('.reply_message_err').html('Type Your Message First!');
                    $(this).closest('tr').find('.reply_message_err').css('color', 'red');
                    event.preventDefault(); // Prevent the default form submission
                }
                else if(length <10){
                    $(this).closest('tr').find('textarea').css('border', '2px solid red');
                    $(this).closest('tr').find('textarea').focus();
                    $(this).closest('tr').find('.reply_message_err').html('Minimum 10 character Required!');
                    $(this).closest('tr').find('.reply_message_err').css('color', 'red');
                    event.preventDefault(); // Prevent the default form submission
                }
                else{
                    $(this).closest('tr').find('textarea').css('border', '3px solid green');
                    $(this).closest('tr').find('.reply_message_err').html('Sending The Message.....');
                    $(this).closest('tr').find('.reply_message_err').css('color', 'green');
                    $('.sending_message_preloader').removeClass('d-none');
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
            $(this).data('custom-value', '1');
        });
    </script>

    <script>
        $('.reply_textarea').click(function(){
            if($(this).closest('tr').find('.reply_message_btn').data('custom-value') == 0){
                Swal.fire({
                position: 'center',
                icon: 'warning',
                text: "Click The Reply Button First!",
                showConfirmButton: false,
                background: '#01186d',
                color: '#d1d1d1',
                iconColor: '#d1d1d1'
                })
            }
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