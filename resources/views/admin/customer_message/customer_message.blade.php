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
</style>

@section('content')
<div class="page-titles">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
        <li class="breadcrumb-item active"><a href="javascript:void(0)">Customer Message</a></li>
    </ol>
</div>

<div class="error_message">
    @error('reply_message')
        <strong class="text-danger">{{$message}}</strong>
    @enderror
</div>

<div class="row">
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
                        <th class="text-center">Action</th>
                    </tr>

                    @foreach ($messages as $key=>$message) 
                        @if ($message->your_reply == null)
                            <tr style="color: red">
                                <form action="{{route('reply_customer_message')}}" method="POST" class="reply_message_form">
                                    @csrf
                                    <td>{{$key+1}}</td>
                                    <td>{{$message->name}}</td>
                                    <td>{{$message->email}}</td>
                                    <td>{{$message->mobile}}</td>
                                    <td style="width: 25%">{{$message->message}}</td>
                                    <td style="width: 25%; padding: 12px 0">
                                        <div class="reply_message">
                                            <input type="hidden" name="message_id" value="{{$message->id}}">
                                            <input type="hidden" name="customer_email_address" value="{{$message->email}}">
                                            <input type="hidden" name="customer_message" value="{{$message->message}}">
                                            <textarea readonly style="color:#646464; border: 1px solid #c1c1c1; cursor: not-allowed;" class="form-control reply_message_text" name="reply_message" title="Click On Reply"></textarea>
                                        </div>                                      
                                    </td>
                                    <td>
                                        <div class="rry">
                                            <button type="button" class="btn_design btn-primary reply_message_btn">Replay</button>
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
        $('.reply_message_btn').click(function(){
            $(this).closest('tr').find('.reply_message_send_btn').removeClass('d-none');
            $(this).closest('tr').find('.reply_message_btn').addClass('d-none');
            $(this).closest('tr').find('textarea').removeAttr('readonly');
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