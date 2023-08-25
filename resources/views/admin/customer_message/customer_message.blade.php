@extends('layouts.dashboard')

@section('content')
<div class="page-titles">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
        <li class="breadcrumb-item active"><a href="javascript:void(0)">Customer Message</a></li>
    </ol>
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
                        <th class="text-center" style="width: 25%">Reply</th>
                        <th class="text-center">Action</th>
                    </tr>
                    @foreach ($messages as $key=>$message) 
                        <tr>
                            <form action="{{route('reply_customer_message')}}" method="POST">
                                @csrf
                                <td>{{$key+1}}</td>
                                <td>{{$message->name}}</td>
                                <td>{{$message->email}}</td>
                                <td>{{$message->mobile}}</td>
                                <td style="width: 25%">{{$message->message}}</td>
                                <td style="width: 25%">
                                    <input type="hidden" name="message_id" value="{{$message->id}}">
                                    <input type="hidden" name="customer_email_address" value="{{$message->email}}">
                                    <input type="hidden" name="customer_message" value="{{$message->message}}">
                                    <textarea style="color:#646464; border: 2px solid #8d8d8d" class="form-control" name="reply_message"></textarea>
                                </td>
                                <td class="text-center">
                                    <button type="submit" class="btn btn-primary">Replay</button>
                                </td>
                            </form>
                        </tr> 
                    @endforeach
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@section('footer_script')
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