

<!DOCTYPE html>
<html lang="en" >
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title> Order confirmation </title>
    <meta name="robots" content="noindex,nofollow" />
    <meta name="viewport" content="width=device-width; initial-scale=1.0;" />
    <style type="text/css">
      @import url(https://fonts.googleapis.com/css?family=Open+Sans:400,700);
      body { margin: 0; padding: 0; background: #e1e1e1; }
      div, p, a, li, td { -webkit-text-size-adjust: none; }
      .ReadMsgBody { width: 100%; background-color: #ffffff; }
      .ExternalClass { width: 100%; background-color: #ffffff; }
      body { width: 100%; height: 100%; background-color: #e1e1e1; margin: 0; padding: 0; -webkit-font-smoothing: antialiased; }
      html { width: 100%; }
      p { padding: 0 !important; margin-top: 0 !important; margin-right: 0 !important; margin-bottom: 0 !important; margin-left: 0 !important; }
      .visibleMobile { display: none; }
      .hiddenMobile { display: block; }

      @media only screen and (max-width: 600px) {
      body { width: auto !important; }
      table[class=fullTable] { width: 96% !important; clear: both; }
      table[class=fullPadding] { width: 85% !important; clear: both; }
      table[class=col] { width: 45% !important; }
      .erase { display: none; }
      }

      @media only screen and (max-width: 420px) {
      table[class=fullTable] { width: 100% !important; clear: both; }
      table[class=fullPadding] { width: 85% !important; clear: both; }
      table[class=col] { width: 100% !important; clear: both; }
      table[class=col] td { text-align: left !important; }
      .erase { display: none; font-size: 0; max-height: 0; line-height: 0; padding: 0; }
      .visibleMobile { display: block !important; }
      .hiddenMobile { display: none !important; }
      }

      .visit_site{
          margin: 20px 0 10px 0;
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
  {{-- mail start --}}
  @php
    $customer_name = Auth::guard('customerlogin')->user()->name;
  @endphp
  <div style="margin-bottom:15px">
    <h3>Hello <span>{{$customer_name}},</span></h3>
    <p style="line-height: 18px; font-weight: 700">Welcome to Pikter IT</p>
    <p style="line-height: 18px">We received one order from you as on <span style="font-weight: 700">{{App\Models\Order::where('order_id', $order_id)->first()->created_at->format('d M,Y')}}</span> against <span style="font-weight: 700">Order ID- {{$order_id}}</span>. The following is your order details-</p>
  </div>

  <!-- invoice header start -->
  <table width="100%" border="0" cellpadding="0" cellspacing="0" align="center" class="fullTable" bgcolor="#e1e1e1">
    <tr>
      <td height="20"></td>
    </tr>
    <tr>
      <td>
        <table width="600" border="0" cellpadding="0" cellspacing="0" align="center" class="fullTable" bgcolor="#ffffff" style="border-radius: 10px 10px 0 0;">
          <tr class="hiddenMobile">
            <td height="40"></td>
          </tr>
          <tr class="visibleMobile">
            <td height="30"></td>
          </tr>

          <tr>
            <td>
              <table width="480" border="0" cellpadding="0" cellspacing="0" align="center" class="fullPadding">
                <tbody>
                  <tr>
                    <td>
                      <table width="220" border="0" cellpadding="0" cellspacing="0" align="left" class="col">
                        <tbody>
                          <tr>
                            <td align="left"> <img style="border-radius: 50%; width: 65px" src="https://i.postimg.cc/wTyd0LCj/channels4-profile.jpg" alt="logo" border="0" /></td>
                          </tr>
                          <tr class="hiddenMobile">
                            <td height="40"></td>
                          </tr>
                          <tr class="visibleMobile">
                            <td height="20"></td>
                          </tr>
                          <tr>
                            <td style="font-size: 12px; color: #5b5b5b; font-family: 'Open Sans', sans-serif; line-height: 18px; vertical-align: top; text-align: left;">
                              Hello, {{Auth::guard('customerlogin')->user()->name}}.
                              <br> Thank you for shopping with us.
                            </td>
                          </tr>
                        </tbody>
                      </table>
                      <table width="220" border="0" cellpadding="0" cellspacing="0" align="right" class="col">
                        <tbody>
                          <tr class="visibleMobile">
                            <td height="20"></td>
                          </tr>
                          <tr>
                            <td height="5"></td>
                          </tr>
                          <tr>
                            <td style="font-size: 21px; color: #ff0000; letter-spacing: -1px; font-family: 'Open Sans', sans-serif; line-height: 1; vertical-align: top; text-align: right;">
                              Invoice
                            </td>
                          </tr>
                          <tr>
                          <tr class="hiddenMobile">
                            <td height="50"></td>
                          </tr>
                          <tr class="visibleMobile">
                            <td height="20"></td>
                          </tr>
                          <tr>
                            <td style="padding-top: 25px; font-size: 12px; color: #5b5b5b; font-family: 'Open Sans', sans-serif; line-height: 18px; vertical-align: top; text-align: right;">
                              <small>Order ID: </small> {{$order_id}}<br />
                              <small>{{App\Models\Order::where('order_id', $order_id)->first()->created_at->format('d-M-Y')}}</small>
                            </td>
                          </tr>
                        </tbody>
                      </table>
                    </td>
                  </tr>
                </tbody>
              </table>
            </td>
          </tr>
        </table>
      </td>
    </tr>
  </table>
  <!-- invoice Header end -->
  <!-- Order Details start -->
  <table width="100%" border="0" cellpadding="0" cellspacing="0" align="center" class="fullTable" bgcolor="#e1e1e1">
    <tbody>
      <tr>
        <td>
          <table width="600" border="0" cellpadding="0" cellspacing="0" align="center" class="fullTable" bgcolor="#ffffff">
            <tbody>
              <tr>
              <tr class="hiddenMobile">
                <td height="60"></td>
              </tr>
              <tr class="visibleMobile">
                <td height="40"></td>
              </tr>
              <tr>
                <td>
                  <table width="480" border="0" cellpadding="0" cellspacing="0" align="center" class="fullPadding">
                    <tbody>
                        <tr>
                            <th style="font-size: 12px; font-family: 'Open Sans', sans-serif; color: #5b5b5b; font-weight: bold; line-height: 1; vertical-align: top; padding: 0 10px 7px 0;" width="30%" align="left">
                            Product Name
                            </th>
                            
                            <th style="font-size: 12px; font-family: 'Open Sans', sans-serif; color: #5b5b5b; font-weight: bold; line-height: 1; vertical-align: top; padding: 0 0 7px;" align="center">
                            Color
                            </th>
                            
                            <th style="font-size: 12px; font-family: 'Open Sans', sans-serif; color: #5b5b5b; font-weight: bold; line-height: 1; vertical-align: top; padding: 0 0 7px;" align="center">
                            Size
                            </th>
                            
                            <th style="font-size: 12px; font-family: 'Open Sans', sans-serif; color: #5b5b5b; font-weight: bold; line-height: 1; vertical-align: top; padding: 0 0 7px;" align="center">
                            Quantity
                            </th>

                            <th style="font-size: 12px; font-family: 'Open Sans', sans-serif; color: #5b5b5b; font-weight: bold; line-height: 1; vertical-align: top; padding: 0 0 7px;" align="center">
                            Unit Price
                            </th>

                            <th style="font-size: 12px; font-family: 'Open Sans', sans-serif; color: #5b5b5b; font-weight: bold; line-height: 1; vertical-align: top; padding: 0 0 7px;" width="15%" align="center">
                            Unit Discount
                            </th>

                            <th style="font-size: 12px; font-family: 'Open Sans', sans-serif; color: #1e2b33; font-weight: bold; line-height: 1; vertical-align: top; padding: 0 0 7px;" align="right">
                            Total
                            </th>
                        </tr>
                        <tr>
                            <td height="1" style="background: #bebebe;" colspan="7"></td>
                        </tr>
                        {{-- <tr>
                            <td height="10" colspan="7"></td>
                        </tr> --}}

                        @foreach (App\Models\OrderProduct::where('order_id', $order_id)->get() as $orderproduct)

                        @php
                          $total_original_price = ($orderproduct->original_price)*($orderproduct->quantity);
                          $total_discount = $total_original_price - $orderproduct->after_discount;
                          $per_unit_discount = $total_discount/$orderproduct->quantity;
                        @endphp
                            <tr>
                                <td style="font-size: 12px; font-family: 'Open Sans', sans-serif; color: #000;  line-height: 18px;  vertical-align: top; padding:10px 0;" class="article">
                                {{$orderproduct->rel_to_product->product_name}}
                                </td>
                                
                                <td style="font-size: 12px; font-family: 'Open Sans', sans-serif; color: #646a6e;  line-height: 18px;  vertical-align: top; padding:10px 0;" align="center">
                                {{$orderproduct->rel_to_color->color_name}}
                                </td>
                                
                                <td style="font-size: 12px; font-family: 'Open Sans', sans-serif; color: #646a6e;  line-height: 18px;  vertical-align: top; padding:10px 0;" align="center">
                                {{$orderproduct->rel_to_size->size_name}}
                                </td>
                                
                                <td style="font-size: 12px; font-family: 'Open Sans', sans-serif; color: #646a6e;  line-height: 18px;  vertical-align: top; padding:10px 0;" align="center">
                                {{$orderproduct->quantity}}
                                </td>
                                
                                <td style="font-size: 12px; font-family: 'Open Sans', sans-serif; color: #646a6e;  line-height: 18px;  vertical-align: top; padding:10px 0;" align="center">
                                {{$orderproduct->original_price}}
                                </td>
                                
                                <td style="font-size: 12px; font-family: 'Open Sans', sans-serif; color: #646a6e;  line-height: 18px;  vertical-align: top; padding:10px 0;" align="center">
                                {{$per_unit_discount}}
                                </td>

                                <td style="font-size: 12px; font-family: 'Open Sans', sans-serif; color: #1e2b33;  line-height: 18px;  vertical-align: top; padding:10px 0;" align="right">
                                {{$orderproduct->after_discount}}
                                </td>

                            </tr>
                            <tr>
                                <td height="1" colspan="7" style="border-bottom:1px solid #e4e4e4"></td>
                            </tr>
                        @endforeach
                    </tbody>
                  </table>
                </td>
              </tr>
              <tr>
                <td height="20"></td>
              </tr>
            </tbody>
          </table>
        </td>
      </tr>
    </tbody>
  </table>
  <!-- /Order Details end -->
  <!-- Total start -->
  <table width="100%" border="0" cellpadding="0" cellspacing="0" align="center" class="fullTable" bgcolor="#e1e1e1">
    <tbody>
      <tr>
        <td>
          <table width="600" border="0" cellpadding="0" cellspacing="0" align="center" class="fullTable" bgcolor="#ffffff">
            <tbody>
              <tr>
                <td>

                  <!-- Table Total -->
                  <table width="480" border="0" cellpadding="0" cellspacing="0" align="center" class="fullPadding">
                    <tbody>
                        
                      <tr>
                        <td style="font-size: 12px; font-family: 'Open Sans', sans-serif; color: #646a6e; line-height: 22px; vertical-align: top; text-align:right; ">
                          Total Original Price:
                        </td>
                        <td style="font-size: 12px; font-family: 'Open Sans', sans-serif; color: #646a6e; line-height: 22px; vertical-align: top; text-align:right; white-space:nowrap;" width="80">
                            {{App\Models\Order::where('order_id', $order_id)->first()->sub_total}}
                        </td>
                      </tr>
                      <tr>
                        <td style="font-size: 12px; font-family: 'Open Sans', sans-serif; color: #646a6e; line-height: 22px; vertical-align: top; text-align:right; ">
                          (-) Total Sales Discount:
                        </td>
                        <td style="font-size: 12px; font-family: 'Open Sans', sans-serif; color: #646a6e; line-height: 22px; vertical-align: top; text-align:right; ">
                            {{App\Models\Order::where('order_id', $order_id)->first()->sales_discount}}
                        </td>
                      </tr>
                      <tr>
                        <td style="font-size: 12px; font-family: 'Open Sans', sans-serif; color: #646a6e; line-height: 22px; vertical-align: top; text-align:right; ">
                          (-) Coupon Discount:
                        </td>
                        <td style="font-size: 12px; font-family: 'Open Sans', sans-serif; color: #646a6e; line-height: 22px; vertical-align: top; text-align:right; ">
                            {{App\Models\Order::where('order_id', $order_id)->first()->coupon_discount}}
                        </td>
                      </tr>
                      <tr>
                        <td style="font-size: 12px; font-family: 'Open Sans', sans-serif; color: #646a6e; line-height: 22px; vertical-align: top; text-align:right; ">
                          (+) Delivery Charge:
                        </td>
                        <td style="font-size: 12px; font-family: 'Open Sans', sans-serif; color: #646a6e; line-height: 22px; vertical-align: top; text-align:right; ">
                            {{App\Models\Order::where('order_id', $order_id)->first()->delivery_charge}}
                        </td>
                      </tr>
                      <tr>
                        <td style="font-size: 12px; font-family: 'Open Sans', sans-serif; color: #000; line-height: 22px; vertical-align: top; text-align:right; ">
                          <strong>Grand Total:</strong>
                        </td>
                        <td style="font-size: 12px; font-family: 'Open Sans', sans-serif; color: #000; line-height: 22px; vertical-align: top; text-align:right; ">
                          <strong>{{App\Models\Order::where('order_id', $order_id)->first()->total}}</strong>
                        </td>
                      </tr>
                      
                    </tbody>
                  </table>
                  <!-- /Table Total -->

                </td>
              </tr>
            </tbody>
          </table>
        </td>
      </tr>
    </tbody>
  </table>
  <!-- /Total end -->
  <!-- Information start -->
  <table width="100%" border="0" cellpadding="0" cellspacing="0" align="center" class="fullTable" bgcolor="#e1e1e1">
    <tbody>
      <tr>
        <td>
          <table width="600" border="0" cellpadding="0" cellspacing="0" align="center" class="fullTable" bgcolor="#ffffff">
            <tbody>
              <tr>
              <tr class="hiddenMobile">
                <td height="60"></td>
              </tr>
              <tr class="visibleMobile">
                <td height="40"></td>
              </tr>
              <tr>
                <td>
                  <table width="480" border="0" cellpadding="0" cellspacing="0" align="center" class="fullPadding">
                    <tbody>
                      <tr>
                        <td>
                          <table width="220" border="0" cellpadding="0" cellspacing="0" align="left" class="col">

                            <tbody>
                              <tr>
                                <td style="font-size: 11px; font-family: 'Open Sans', sans-serif; color: #5b5b5b; line-height: 1; vertical-align: top; ">
                                  <strong>BILLING INFORMATION</strong>
                                </td>
                              </tr>
                              <tr>
                                <td width="100%" height="10"></td>
                              </tr>
                              @php
                                $city_id = App\Models\BillingDetails::where('order_id', $order_id)->first()->city_id;
                                $country_id = App\Models\BillingDetails::where('order_id', $order_id)->first()->country_id;
                              @endphp
                              <tr>
                                <td style="font-size: 12px; font-family: 'Open Sans', sans-serif; color: #5b5b5b; line-height: 20px; vertical-align: top; ">
                                  {{App\Models\BillingDetails::where('order_id', $order_id)->first()->name}}
                                  <br> 
                                  {{App\Models\BillingDetails::where('order_id', $order_id)->first()->email}}
                                  <br> 
                                  {{App\Models\BillingDetails::where('order_id', $order_id)->first()->address}}
                                  <br> 
                                  {{App\Models\City::find($city_id)->name}}-
                                  {{App\Models\BillingDetails::where('order_id', $order_id)->first()->zip}},
                                  {{App\Models\Country::find($country_id)->name}}
                                  <br>
                                  Mobile: {{App\Models\BillingDetails::where('order_id', $order_id)->first()->mobile}}
                                </td>
                              </tr>
                            </tbody>
                          </table>


                          <table width="220" border="0" cellpadding="0" cellspacing="0" align="right" class="col">
                            <tbody>
                              <tr class="visibleMobile">
                                <td height="20"></td>
                              </tr>
                              <tr>
                                <td style="font-size: 11px; font-family: 'Open Sans', sans-serif; color: #5b5b5b; line-height: 1; vertical-align: top; ">
                                  <strong>PAYMENT METHOD</strong>
                                </td>
                              </tr>
                              <tr>
                                <td width="100%" height="10"></td>
                              </tr>
                              @if(App\Models\Order::where('order_id', $order_id)->first()->payment_method !=1)
                                <tr>
                                    <td style="font-size: 12px; font-family: 'Open Sans', sans-serif; color: #5b5b5b; line-height: 20px; vertical-align: top; ">
                                    Credit Card<br> Credit Card Type: Visa<br> Worldpay Transaction ID: <a href="#" style="color: #ff0000; text-decoration:underline;">4185939336</a><br>
                                    <a href="#" style="color:#b0b0b0;">Right of Withdrawal</a>
                                    </td>
                                </tr>
                                @else
                                <tr>
                                    <td style="font-size: 12px; font-family: 'Open Sans', sans-serif; color: #5b5b5b; line-height: 20px; vertical-align: top; ">Cash on delivery</td>
                                </tr>
                               @endif
                            </tbody>
                          </table>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </td>
              </tr>

              <tr class="hiddenMobile">
                <td height="60"></td>
              </tr>
              <tr class="visibleMobile">
                <td height="30"></td>
              </tr>
            </tbody>
          </table>
        </td>
      </tr>
    </tbody>
  </table>
  <!-- /Information end -->
  <table width="100%" border="0" cellpadding="0" cellspacing="0" align="center" class="fullTable" bgcolor="#e1e1e1">

    <tr>
      <td>
        <table width="600" border="0" cellpadding="0" cellspacing="0" align="center" class="fullTable" bgcolor="#ffffff" style="border-radius: 0 0 10px 10px;">
          <tr>
            <td>
              <table width="480" border="0" cellpadding="0" cellspacing="0" align="center" class="fullPadding">
                <tbody>
                  <tr>
                    {{-- ========== download invoice ========== --}}
                    <td style="font-size: 12px; color: #5b5b5b; font-family: 'Open Sans', sans-serif; line-height: 18px; vertical-align: top; text-align: center;">
                      <a href="{{route('Download_invoice', substr($order_id,1))}}" style="background: #0B2A97; color: #fff; padding: 10px 20px; font-family: 'Open Sans', sans-serif; font-size: 12px; font-weight: 600; text-decoration: none; border-radius: 10px">Download Invoice</a>
                    </td>
                  </tr>
                </tbody>
              </table>
            </td>
          </tr>
          <tr class="spacer">
            <td height="50"></td>
          </tr>

        </table>
      </td>
    </tr>
    <tr>
      <td height="20"></td>
    </tr>
  </table>

  <div>
    <h4 style="line-height: 5px">Thank you for visiting our website & for your order.</h4>
    <h4 style="padding-bottom: 15px; line-height: 5px">Wish you will be always with us.</h4>

    <a href="https://pikterit.com/"><img style="border-radius: 50%; width: 80px" src="https://i.postimg.cc/wTyd0LCj/channels4-profile.jpg" alt="logo"></a>
    <h2 style="line-height:18px"> Pikter <span style="color: red">IT</span></h2>
    <p style="line-height: 18px">Shop No-309, Level-3</p>
    <p style="line-height: 18px">Multiplan Center</p>
    <p style="line-height: 18px">Elephent Road, Dhaka.</p>
    <p style="line-height: 18px"> <span>Email:</span> pikterit@gmail.com</p>
    <p style="line-height: 18px"> <span>Website:</span> https://pikterit.com</p>
    <p style="line-height: 18px">Contact: 01623486100 & 01623486101</p>
    <div class="visit_site"><a href="https://pikterit.com/">Visit Our Website</a></div>
    <div>
        <span style="margin: 0 10px 0 0"><a href="https://www.facebook.com/pikteritltd"><img style="width: 28px" src="https://i.postimg.cc/Qt6zR201/facebook-174848.png" alt="facebook"></a></span>
        <span style="margin: 10px 10px 0 0"><a href="https://www.youtube.com/@pikterit"><img style="width: 33px" src="https://i.postimg.cc/k45S2KsW/youtube-1384060.png" alt="youtube"></a></span>
        <span style="0 10px 0 0"><a href="https://pikterit.com/"><img style="width: 28px" src="https://i.postimg.cc/MH2s2z1c/planet-earth-921490.png" alt="website"></a></span>
    </div>
  </div>

  
</body>
</html>
