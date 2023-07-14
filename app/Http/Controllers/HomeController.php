<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Models\Order;
use Carbon\Carbon;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request){
 
        $roles = Role::all();

        // Todays order ==========================================================
        $current_date = Carbon::today()->format('d/m/Y');  // to show the date on blade
        $todays_sales_number = Order::whereDate('created_at', Carbon::today())->count();
        $todays_sales_amount = Order::whereDate('created_at', Carbon::today())->sum('total');



        // Last 7 days order ======================================================
        $start_7th_date = Carbon::today()->subDays(6)->format('d/m/Y');  // to show the date on blade
        $last_7th_date = Carbon::today()->subDays(6);
        $last_7_days_sales_number = Order::where('created_at', '>=', $last_7th_date)->count();
        $last_7_days_sales_amount = Order::where('created_at', '>=', $last_7th_date)->sum('total');

            // last 7 days sales data for chart.js ===
            $last_7_days_daily_sales_number = array(); // here array is created
            $last_7_days_daily_sales_amount = array(); // here array is created
            $last_7_days_sales_date = array();  // here array is created

            for($i=0; $i < 7; $i++){
                $date = Carbon::today()->subDays(6)->addDays($i)->format('Y-m-d');
                $date_with_start_time = $date.' 00:00:00';
                $date_with_end_time = $date.' 23:59:59';
                $daily_sales_number = Order::whereBetween('created_at', [$date_with_start_time,$date_with_end_time])->count();
                $daily_sales_amount = Order::whereBetween('created_at', [$date_with_start_time,$date_with_end_time])->sum('total');
                $daily_date = Carbon::today()->subDays(6)->addDays($i)->format('d F, y');
                array_push($last_7_days_daily_sales_number, $daily_sales_number);  // inserts one or more elements to array
                array_push($last_7_days_daily_sales_amount, $daily_sales_amount);  // inserts one or more elements to array
                array_push($last_7_days_sales_date, $daily_date);  // inserts one or more elements to array 
            }
            $last_7_days_daily_sales_number = json_encode($last_7_days_daily_sales_number);  // convert array to object
            $last_7_days_daily_sales_amount = json_encode($last_7_days_daily_sales_amount);  // convert array to object
            $last_7_days_sales_date = json_encode($last_7_days_sales_date);  // convert array to object



        // Last 30 days order ======================================================== 
        $start_30th_date = Carbon::today()->subDays(29)->format('d/m/Y');  // to show the date on blade
        $last_30th_date = Carbon::today()->subDays(29);
        $last_30_days_sales_number = Order::where('created_at', '>=', $last_30th_date)->count();
        $last_30_days_sales_amount = Order::where('created_at', '>=', $last_30th_date)->sum('total');

            // last 30 days sales data for chart.js ===
            $last_30_days_daily_sales_number = array(); // here array is created
            $last_30_days_daily_sales_amount = array(); // here array is created
            $last_30_days_sales_date = array();  // here array is created

            for($i=0; $i < 30; $i++){
                $date = Carbon::today()->subDays(29)->addDays($i)->format('Y-m-d');
                $date_with_start_time = $date.' 00:00:00';
                $date_with_end_time = $date.' 23:59:59';
                $daily_sales_number = Order::whereBetween('created_at', [$date_with_start_time,$date_with_end_time])->count();
                $daily_sales_amount = Order::whereBetween('created_at', [$date_with_start_time,$date_with_end_time])->sum('total');
                $daily_date = Carbon::today()->subDays(29)->addDays($i)->format('d-M');
                array_push($last_30_days_daily_sales_number, $daily_sales_number);  // inserts one or more elements to array
                array_push($last_30_days_daily_sales_amount, $daily_sales_amount);  // inserts one or more elements to array
                array_push($last_30_days_sales_date, $daily_date);  // inserts one or more elements to array 
            }
            $last_30_days_daily_sales_number = json_encode($last_30_days_daily_sales_number);  // convert array to object
            $last_30_days_daily_sales_amount = json_encode($last_30_days_daily_sales_amount);  // convert array to object
            $last_30_days_sales_date = json_encode($last_30_days_sales_date);  // convert array to object



        // Current weekly sales order ================================================
            // customize week stat & end day ===
            $week_start_day = Carbon::now()->startOfWeek(Carbon::SATURDAY);
            $week_end_day = Carbon::now()->endOfWeek(Carbon::FRIDAY);
            
        $current_week_sales_number = Order::whereBetween('created_at',[$week_start_day,$week_end_day])->count();
        $current_week_sales_amount = Order::whereBetween('created_at',[$week_start_day,$week_end_day])->sum('total');

            // current week sales data for chart.js ===
            $current_week_daily_sales_number = array(); // here array is created
            $current_week_daily_sales_amount = array(); // here array is created
            $current_week_sales_date = array();  // here array is created

            // calculation to find out how many days are passed including today in this week, to apply in for()loop ===
            $current_week_start_date = Carbon::now()->startOfWeek(Carbon::SATURDAY)->format('d');
            $today = Carbon::today()->format('d'); 
            $current_week_day_already_passed_with_today = ($today - $current_week_start_date) + 1;

            for($i=0; $i < $current_week_day_already_passed_with_today; $i++){
                $date = Carbon::now()->startOfWeek(Carbon::SATURDAY)->addDays($i)->format('Y-m-d');
                $date_with_start_time = $date.' 00:00:00';
                $date_with_end_time = $date.' 23:59:59';
                $daily_sales_number = Order::whereBetween('created_at', [$date_with_start_time,$date_with_end_time])->count();
                $daily_sales_amount = Order::whereBetween('created_at', [$date_with_start_time,$date_with_end_time])->sum('total');
                $daily_date = Carbon::now()->startOfWeek(Carbon::SATURDAY)->addDays($i)->isoFormat('dddd');
                array_push($current_week_daily_sales_number, $daily_sales_number);  // inserts one or more elements to array
                array_push($current_week_daily_sales_amount, $daily_sales_amount);  // inserts one or more elements to array
                array_push($current_week_sales_date, $daily_date);  // inserts one or more elements to array 
            }
            $current_week_daily_sales_number = json_encode($current_week_daily_sales_number);  // convert array to object data
            $current_week_daily_sales_amount = json_encode($current_week_daily_sales_amount);  // convert array to object data
            $current_week_sales_date = json_encode($current_week_sales_date);  // convert array to object data



        // compare weekly sales data between current week & previous week for chart.js ==================
        $previous_week_daily_sales_number = array(); // here array is created
        $previous_week_daily_sales_amount = array(); // here array is created

        for($i=0; $i < 7; $i++){
                $date = Carbon::now()->startOfWeek(Carbon::SATURDAY)->subDays(7)->addDays($i)->format('Y-m-d');
                $date_with_start_time = $date.' 00:00:00';
                $date_with_end_time = $date.' 23:59:59';
                $daily_sales_number = Order::whereBetween('created_at', [$date_with_start_time,$date_with_end_time])->count();
                $daily_sales_amount = Order::whereBetween('created_at', [$date_with_start_time,$date_with_end_time])->sum('total');
                array_push($previous_week_daily_sales_number, $daily_sales_number);  // inserts one or more elements to array
                array_push($previous_week_daily_sales_amount, $daily_sales_amount);  // inserts one or more elements to array
        }
        $previous_week_daily_sales_number = json_encode($previous_week_daily_sales_number);  // convert array to object
        $previous_week_daily_sales_amount = json_encode($previous_week_daily_sales_amount);  // convert array to object



        // Monthly sales order ======================================================== 
        $current_month = Carbon::now()->format('F, Y');
        $current_month_sales_number = Order::whereMonth('created_at', Carbon::now()->month)->count();
        $current_month_sales_amount = Order::whereMonth('created_at', Carbon::now()->month)->sum('total');

            // current month sales data for chart.js ===
            $current_month_daily_sales_number = array(); // here array is created
            $current_month_daily_sales_amount = array(); // here array is created
            $current_month_sales_date = array();  // here array is created

            // calculation to find out how many days are passed including today in this month, to apply in for()loop ===
            $current_month_start_date = Carbon::now()->startOfMonth()->format('d'); 
            $today = Carbon::today()->format('d'); 
            $current_month_day_already_passed_with_today = ($today - $current_month_start_date) + 1;

            for($i=0; $i < $current_month_day_already_passed_with_today; $i++){
                $date = Carbon::now()->startOfMonth()->addDays($i)->format('Y-m-d');
                $date_with_start_time = $date.' 00:00:00';
                $date_with_end_time = $date.' 23:59:59';
                $daily_sales_number = Order::whereBetween('created_at', [$date_with_start_time,$date_with_end_time])->count();
                $daily_sales_amount = Order::whereBetween('created_at', [$date_with_start_time,$date_with_end_time])->sum('total');
                $daily_date = Carbon::now()->startOfMonth()->addDays($i)->format('d');
                array_push($current_month_daily_sales_number, $daily_sales_number);  // inserts one or more elements to array
                array_push($current_month_daily_sales_amount, $daily_sales_amount);  // inserts one or more elements to array
                array_push($current_month_sales_date, $daily_date);  // inserts one or more elements to array 
            }
            $current_month_daily_sales_number = json_encode($current_month_daily_sales_number);  // convert array to object
            $current_month_daily_sales_amount = json_encode($current_month_daily_sales_amount);  // convert array to object
            $current_month_sales_date = json_encode($current_month_sales_date);  // convert array to object
            


        // compare monthly sales data between current month & previous month for chart.js ==================
        $previous_month_daily_sales_number = array(); // here array is created
        $previous_month_daily_sales_amount = array(); // here array is created
        $maximum_day_of_a_month = array(); // here array is created

        $previous_month = Carbon::now()->subMonth(1)->endOfMonth()->format('F, Y'); // to show the date on blade
        $last_day_of_previous_month = Carbon::now()->subMonth(1)->endOfMonth()->format('d');

        for($i=0; $i < $last_day_of_previous_month; $i++){
                $date = Carbon::now()->subMonth(1)->startOfMonth()->addDays($i)->format('Y-m-d');
                $date_with_start_time = $date.' 00:00:00';
                $date_with_end_time = $date.' 23:59:59';
                $daily_sales_number = Order::whereBetween('created_at', [$date_with_start_time,$date_with_end_time])->count();
                $daily_sales_amount = Order::whereBetween('created_at', [$date_with_start_time,$date_with_end_time])->sum('total');
                array_push($previous_month_daily_sales_number, $daily_sales_number);  // inserts one or more elements to array
                array_push($previous_month_daily_sales_amount, $daily_sales_amount);  // inserts one or more elements to array
        }

        for($i = 1; $i <= 31; $i++){
            $daily_date = 0 + $i;
            array_push($maximum_day_of_a_month, $daily_date);  // inserts one or more elements to array 
        }
        $previous_month_daily_sales_number = json_encode($previous_month_daily_sales_number);  // convert array to object
        $previous_month_daily_sales_amount = json_encode($previous_month_daily_sales_amount);  // convert array to object
        $maximum_day_of_a_month = json_encode($maximum_day_of_a_month);  // convert array to object



        // Yearly sales order =========================================================
        $current_year = Carbon::now()->year;  // to show the date on blade
        $yearly_sales_number = Order::whereYear('created_at', Carbon::now()->year)->count();
        $yearly_sales_amount = Order::whereYear('created_at', Carbon::now()->year)->sum('total');

        // current year sales data for chart.js ===
            $current_year_monthly_sales_number = array(); // here array is created
            $current_year_monthly_sales_amount = array(); // here array is created
            $current_year_sales_month = array();  // here array is created

            // calculation to find out how many months are passed in this year, to apply in for()loop ===
            $current_year_start_month = Carbon::now()->startOfYear()->startOfMonth()->format('m'); 
            $this_month = Carbon::now()->format('m');; 
            $month_already_passed = ($this_month - $current_year_start_month) + 1;

            for($i=0; $i < $month_already_passed; $i++){
                $month_start = Carbon::now()->startOfYear()->startOfMonth()->addMonths($i)->format('Y-m-d');
                $month_end = Carbon::now()->startOfYear()->endOfMonth()->addMonths($i)->format('Y-m-d');
                $month_start_with_time = $month_start.' 00:00:00';
                $month_end_with_time = $month_end.' 23:59:59';
                $monthly_sales_number = Order::whereBetween('created_at', [$month_start_with_time,$month_end_with_time])->count();
                $monthly_sales_amount = Order::whereBetween('created_at', [$month_start_with_time,$month_end_with_time])->sum('total');
                $month_name = Carbon::now()->startOfYear()->startOfMonth()->addMonths($i)->format('F');
                array_push($current_year_monthly_sales_number, $monthly_sales_number);  // inserts one or more elements to array
                array_push($current_year_monthly_sales_amount, $monthly_sales_amount);  // inserts one or more elements to array
                array_push($current_year_sales_month, $month_name);  // inserts one or more elements to array 
            }
            $current_year_monthly_sales_number = json_encode($current_year_monthly_sales_number);  // convert array to object
            $current_year_monthly_sales_amount = json_encode($current_year_monthly_sales_amount);  // convert array to object
            $current_year_sales_month = json_encode($current_year_sales_month);  // convert array to object



        // Custom search sales order ================================================== 
        $search_start_date = $request->search_start_date;
        $search_start_date_with_time = $search_start_date.' 00:00:00';
        $search_end_date = $request->search_end_date;
        $search_end_date_with_time = $search_end_date.' 23:59:59';

        $custom_search_sales_number = Order::whereBetween('created_at', [$search_start_date_with_time, $search_end_date_with_time])->count();
        
        $custom_search_sales_amount = Order::whereBetween('created_at', [$search_start_date_with_time, $search_end_date_with_time])->sum('total');


        // search order status ============
        $order_status = array();
        $payment_method = array();

        if($request->custom_search == 1){
            for($i = 1; $i <= 6; $i++){
                $search_order_status = Order::whereBetween('created_at', [$search_start_date_with_time, $search_end_date_with_time])->where('order_status', $i)->count();
                array_push($order_status, $search_order_status);
            }
            
            for($i = 1; $i <= 3; $i++){
                $search_payment_method = Order::whereBetween('created_at', [$search_start_date_with_time, $search_end_date_with_time])->where('payment_method', $i)->count();
                array_push($payment_method, $search_payment_method);
            }

        }
        else{
            for($i = 1; $i <= 6; $i++){
                $all_order_status = Order::where('order_status', $i)->count();
                array_push($order_status, $all_order_status);
            }
            for($i = 1; $i <= 6; $i++){
                $all_payment_method = Order::where('payment_method', $i)->count();
                array_push($payment_method, $all_payment_method);
            }
        }

        $order_status = json_encode($order_status);
        $payment_method = json_encode($payment_method);




        return view('home',[
            'roles'=>$roles,

            'current_date'=>$current_date,
            'current_month'=>$current_month,
            'previous_month'=>$previous_month,
            'current_year'=>$current_year,

            'start_7th_date'=>$start_7th_date,
            'start_30th_date'=>$start_30th_date,

            'todays_sales_number'=>$todays_sales_number,
            'todays_sales_amount'=>$todays_sales_amount,

            'order_status'=>$order_status,
            'payment_method'=>$payment_method,

            'last_7_days_sales_number'=>$last_7_days_sales_number,
            'last_7_days_sales_amount'=>$last_7_days_sales_amount,
            'last_7_days_daily_sales_number'=>$last_7_days_daily_sales_number,
            'last_7_days_daily_sales_amount'=>$last_7_days_daily_sales_amount,
            'last_7_days_sales_date'=>$last_7_days_sales_date,

            'last_30_days_sales_number'=>$last_30_days_sales_number,
            'last_30_days_sales_amount'=>$last_30_days_sales_amount,
            'last_30_days_daily_sales_number'=>$last_30_days_daily_sales_number,
            'last_30_days_daily_sales_amount'=>$last_30_days_daily_sales_amount,
            'last_30_days_sales_date'=>$last_30_days_sales_date,

            'current_week_sales_number'=>$current_week_sales_number,
            'current_week_sales_amount'=>$current_week_sales_amount,
            'current_week_daily_sales_number'=>$current_week_daily_sales_number,
            'current_week_daily_sales_amount'=>$current_week_daily_sales_amount,
            'current_week_sales_date'=>$current_week_sales_date,

            'previous_week_daily_sales_number'=>$previous_week_daily_sales_number,
            'previous_week_daily_sales_amount'=>$previous_week_daily_sales_amount,

            'current_month_sales_number'=>$current_month_sales_number,
            'current_month_sales_amount'=>$current_month_sales_amount,
            'current_month_daily_sales_number'=>$current_month_daily_sales_number,
            'current_month_daily_sales_amount'=>$current_month_daily_sales_amount,
            'current_month_sales_date'=>$current_month_sales_date,

            'previous_month_daily_sales_number'=>$previous_month_daily_sales_number,
            'previous_month_daily_sales_amount'=>$previous_month_daily_sales_amount,
            'maximum_day_of_a_month'=>$maximum_day_of_a_month,

            'yearly_sales_number'=>$yearly_sales_number,
            'yearly_sales_amount'=>$yearly_sales_amount,
            'current_year_monthly_sales_number'=>$current_year_monthly_sales_number,
            'current_year_monthly_sales_amount'=>$current_year_monthly_sales_amount,
            'current_year_sales_month'=>$current_year_sales_month,

            'search_start_date'=>$search_start_date,
            'search_end_date'=>$search_end_date,
            'custom_search_sales_number'=>$custom_search_sales_number,
            'custom_search_sales_amount'=>$custom_search_sales_amount,
        ]);
    }

}
