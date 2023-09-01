<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Invoice</title>
    <style>
      .clearfix:after {
        content: "";
        display: table;
        clear: both;
      }

      a {
        color: #5D6975;
        text-decoration: underline;
      }

      body {
        position: relative;
        height: 29.7cm; 
        margin: 0 auto; 
        color: #001028;
        background: #FFFFFF; 
        font-family: Arial, sans-serif; 
        font-size: 12px; 
        font-family: Arial;
      }

      header {
        padding: 10px 0;
        margin-bottom: 30px;
      }

      #logo {
        text-align: center;
        margin-bottom: 10px;
      }

      #logo img {
        width: 50px;
      }

      #logo .company_name {
        color: #5D6975;
        font-weight: 700;
        font-size: 17px;
      }

      #logo .company_email {
        color: blue;
        text-decoration: none;
        font-weight: 400;
        font-size: 13px;
        transition: .3s;
      }
      #logo .company_email:hover{
        color: rgb(56, 141, 252);
      }

      #logo .company_info {
        color: #5D6975;
        font-weight: 400;
        font-size: 12px;
        margin-top: 2px;
      }

      
      .invoice_head{
        position: relative;
      }
      
      .invoice_span{
        position: absolute;
        top: 0;
        right: 0;
        margin: 0 0 20px 0;
        padding: 2px;
      }

      h1 {
        border-top: 1px solid  #5D6975;
        border-bottom: 1px solid  #5D6975;
        color: #5D6975;
        font-size: 1.2em;
        line-height: 1.2em;
        font-weight: normal;
        text-align: left;
        margin: 0 0 20px 0;
        padding: 2px;
        background: url(dimension.png);
      }

      #project {
        float: left;
        margin-left: 10px;
      }

      #project span {
        color: #5D6975;
        text-align: right;
        width: 52px;
        margin-right: 10px;
        display: inline-block;
        font-size: 0.8em;
      }

      #company {
        float: right;
        margin-right: 10px;
      }

      #project div,
      #company div {
        white-space: nowrap;        
      }

      table {
        width: 100%;
        border-collapse: collapse;
        border-spacing: 0;
        margin-bottom: 20px;
      }

      table tr:nth-child(2n-1) td {
        background: #F5F5F5;
      }


      table th {
        padding: 5px 10px;
        border-bottom: 2px solid #5D6975;
        white-space: nowrap;        
      }

      table td {
        padding: 10px;
      }

      table th.common {
        text-align: center;
        color: #5D6975;
        font-weight: 500;
      }

      table td.common {
        text-align: center;
        color: #5D6975;
        border-bottom: 1px solid #5D6975;
      }

      table tr.final {
        text-align: right;
        color: #5D6975;
      }

      table tr.final_amount {
        text-align: right;
        color: #5D6975;
      }

      table td.grand {
        border-top: 1px solid #5D6975;
        border-bottom: 2px solid #5D6975;
        font-weight: 500;
      }

      #notices .notice_head {
        color: #5D6975;
        font-size: 1.2em;
      }

      .wish {
        color: #5D6975;
        font-size: 1.3em;
        text-align: center;
        margin-bottom: 15px;
      }

      #notices .notice {
        color: #5D6975;
        font-size: 1em;
      }

      footer {
        color: #5D6975;
        width: 100%;
        margin-top: 50px;
        padding: 8px 0;
        text-align: center;
      }
    </style>

  </head>
  <body>
    <header class="clearfix">
      <div id="logo">
        <img style="border-radius: 50%; width: 80px" src="https://i.postimg.cc/wTyd0LCj/channels4-profile.jpg" alt="logo" />
        <div class="company_name"><span style="color: #000">Pikter</span> <span style="color: red">IT</span></div>
        <div class="company_info">Shop No-309, Level-3, Multiplan Center, Elephent Road, Dhaka.</div>
        <div><a href="mailto:laravelcompany@gmail.com" class="company_email">pikterit@gmail.com</a></div>
        <div class="company_info">Contact: 01623486100, 01623486101</div>
      </div >
        <h1 class="invoice_head">Invoice No: <span class="invoice_number">{{$order_id}}</span> 
          <span class="invoice_span" style="text-align: right">Payment Method <div style="font-size: 12px">
            @if (App\Models\Order::where('order_id', $order_id)->first()->payment_method ==1)
              Cash On Delivery             
            @endif
            @if (App\Models\Order::where('order_id', $order_id)->first()->payment_method ==2)
              Card/Mobile Banking            
            @endif
            @if (App\Models\Order::where('order_id', $order_id)->first()->payment_method ==3)
              Stripe Payment            
            @endif
          </div> </span>
          <div style="font-size: 12px">Date: {{App\Models\Order::where('order_id', $order_id)->first()->created_at->format('d-M-Y')}}</div>
        </h1>
        
        @php
          $city_id = App\Models\BillingDetails::where('order_id', $order_id)->first()->city_id;
          $country_id = App\Models\BillingDetails::where('order_id', $order_id)->first()->country_id;
        @endphp
        
      <div id="company" class="clearfix">
        <div style="font-weight: 600; font-size: 13px; color: #5D6975; padding-bottom: 5px">Billing Address:</div>
        <div style="color: #5D6975; padding-bottom: 2px">{{App\Models\BillingDetails::where('order_id', $order_id)->first()->name}}</div>
        <div><a href="mailto:john@example.com" style="color: blue; text-decoration: none">{{App\Models\BillingDetails::where('order_id', $order_id)->first()->email}}</a></div>
        <div style="color: #5D6975; padding: 2px 0 2px 0">{{App\Models\BillingDetails::where('order_id', $order_id)->first()->address}}, {{App\Models\City::find($city_id)->name}}- {{App\Models\BillingDetails::where('order_id', $order_id)->first()->zip}}, {{App\Models\Country::find($country_id)->name}}</div>
        <div style="color: #5D6975; padding-bottom: 2px">{{App\Models\BillingDetails::where('order_id', $order_id)->first()->mobile}}</div>
      </div>
      <div id="project">
        @php
          $customer_name = App\Models\CustomerLogin::where('id', $customer_id)->first()->name;
          // $customer_email = App\Models\CustomerLogin::where('id', $customer_id)->first()->email;
          // $customer_address = App\Models\CustomerLogin::where('id', $customer_id)->first()->address;
          // $customer_mobile = App\Models\CustomerLogin::where('id', $customer_id)->first()->mobile;
        @endphp
        <div style="font-weight: 600; font-size: 13px; color: #5D6975; padding-bottom: 5px">Customers Information:</div>
        {{-- <div style="color: #5D6975; padding-bottom: 2px">Jakir Hossain</div> --}}
        <div style="color: #5D6975; padding-bottom: 2px">{{$customer_name}}</div>
        {{-- <div style="color: #5D6975; padding-bottom: 2px">{{Auth::guard('customerlogin')->user()->name}}</div> --}}
        <div><a href="mailto:jakir0809@gmail.com" style="color: blue; text-decoration: none">jakir0809@gmail.com</a></div>
        <div style="color: #5D6975; padding: 2px 0 2px 0">1426/A, South Donia, Dhaka</div>
        <div style="color: #5D6975; padding-bottom: 2px">01922446000</div>
      </div>
    </header>
    <main>
      <table>
        <thead>
          <tr >
            <th class="common" >SL</th>
            <th class="common" >Product Name</th>
            <th class="common" >Color</th>
            <th class="common" >Size</th>
            <th class="common" >Quantity</th>
            <th class="common" >Unit Price</th>
            <th class="common" >Unit Discount</th>
            <th class="common" >Total</th>
          </tr>
        </thead>
        <tbody>
          @foreach (App\Models\OrderProduct::where('order_id', $order_id)->get() as $sl=>$orderproduct)
          @php
            $total_original_price = ($orderproduct->original_price)*($orderproduct->quantity);
            $total_discount = $total_original_price - $orderproduct->after_discount;
            $per_unit_discount = $total_discount/$orderproduct->quantity;
          @endphp
          <tr>
            <td class="common" >{{$sl+1}}</td>
            <td class="common" >{{$orderproduct->rel_to_product->product_name}}</td>
            <td class="common" >{{$orderproduct->rel_to_color->color_name}}</td>
            <td class="common" >{{$orderproduct->rel_to_size->size_name}}</td>
            <td class="common" >{{$orderproduct->quantity}}</td>
            <td class="common" >{{$orderproduct->original_price}}</td>
            <td class="common" >{{$per_unit_discount}}</td>
            {{-- <td class="common" >{{($orderproduct->original_price)*($orderproduct->quantity) - ($orderproduct->after_discount)}}</td> --}}
            <td class="common" >{{$orderproduct->after_discount}}</td>
            {{-- <td class="common" >{{$orderproduct->after_discount*$orderproduct->quantity}}</td> --}}
          </tr>
          @endforeach
          <tr class="final">
            <td class="final_amount" colspan="7">Total Original Price</td>
            <td class="final_amount">{{App\Models\Order::where('order_id', $order_id)->first()->sub_total}}</td>
          </tr>
          <tr class="final">
            <td class="final_amount" colspan="7">(-) Total Sales Discount</td>
            <td class="final_amount">{{App\Models\Order::where('order_id', $order_id)->first()->sales_discount}}</td>
          </tr>
          <tr class="final">
            <td class="final_amount" colspan="7">(-) Coupon Discount</td>
            <td class="final_amount">{{App\Models\Order::where('order_id', $order_id)->first()->coupon_discount}}</td>
          </tr>
          <tr class="final">
            <td class="final_amount" colspan="7">(+) Delivery Charge</td>
            <td class="final_amount">{{App\Models\Order::where('order_id', $order_id)->first()->delivery_charge}}</td>
          </tr>
          <tr class="final">
            <td colspan="7" class="grand total">Grand Total</td>
            <td class="grand total">{{App\Models\Order::where('order_id', $order_id)->first()->total}}</td>
          </tr>
        </tbody>
      </table>
      <div class="wish">Thank you for shopping with us.</div>
      <div id="notices">
        <div class="notice_head">Notice:</div>
        <div class="notice">1. No claim will be concidered after 7 days of receiving the product.</div>
        <div class="notice">2. You can change the product within 7 days of receiving the product (Cash return is not applicable).</div>
        <div class="notice">3. You can cancel the order within 2 days from order placement date.</div>
        <div class="notice">4. After 2 days from order placement date order cancelision charge wiil be applicable (Tk. 100 + Delivery Charge).</div>
      </div>
    </main>
    <footer>
      *** Invoice was created from our computer system and it is valid without our signature and seal. ***
    </footer>
  </body>
</html>

