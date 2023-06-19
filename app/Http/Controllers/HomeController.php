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

        // todays order ======== 
        $current_date = Carbon::today()->format('d/m/Y');
        $daily_sales_number = Order::whereDate('created_at', Carbon::today())->count();
        $daily_sales_amount = Order::whereDate('created_at', Carbon::today())->sum('total');

        // last 7 days order ======== 
        $start_7th_date = Carbon::today()->subDays(6)->format('d/m/Y');
        $last_7th_date = Carbon::today()->subDays(6);
        $last_7_days_sales_number = Order::where('created_at', '>=', $last_7th_date)->count();
        $last_7_days_sales_amount = Order::where('created_at', '>=', $last_7th_date)->sum('total');

        // last 30 days order ======== 
        $start_30th_date = Carbon::today()->subDays(29)->format('d/m/Y');
        $last_30th_date = Carbon::today()->subDays(29);
        $last_30_days_sales_number = Order::where('created_at', '>=', $last_30th_date)->count();
        $last_30_days_sales_amount = Order::where('created_at', '>=', $last_30th_date)->sum('total');

        // weekly sales order ========================================
            // customize week stat & end day ===
            $week_start_day = Carbon::now()->startOfWeek(Carbon::SATURDAY);
            $week_end_day = Carbon::now()->endOfWeek(Carbon::FRIDAY);
            
        $weekly_sales_number = Order::whereBetween('created_at',[$week_start_day,$week_end_day])->count();
        $weekly_sales_amount = Order::whereBetween('created_at',[$week_start_day,$week_end_day])->sum('total');
        $weekly_sales_datails = Order::whereBetween('created_at',[$week_start_day,$week_end_day])->get();

        // monthly sales order ======== 
        $current_month = Carbon::now()->format('F');
        $monthly_sales_number = Order::whereMonth('created_at', Carbon::now()->month)->count();
        $monthly_sales_amount = Order::whereMonth('created_at', Carbon::now()->month)->sum('total');

        // yearly sales order ======== 
        $current_year = Carbon::now()->year;
        $yearly_sales_number = Order::whereYear('created_at', Carbon::now()->year)->count();
        $yearly_sales_amount = Order::whereYear('created_at', Carbon::now()->year)->sum('total');

        // custom search sales order ======== 
        $search_start_date = $request->search_start_date;
        $search_start_date_with_time = $search_start_date.' 00:00:00';
        $search_end_date = $request->search_end_date;
        $search_end_date_with_time = $search_end_date.' 23:59:59';
        $custom_search_sales_number = Order::whereBetween('created_at', [$search_start_date_with_time, $search_end_date_with_time])->count();
        $custom_search_sales_amount = Order::whereBetween('created_at', [$search_start_date_with_time, $search_end_date_with_time])->sum('total');



        return view('home',[
            'roles'=>$roles,
            'current_date'=>$current_date,
            'current_month'=>$current_month,
            'current_year'=>$current_year,
            'start_7th_date'=>$start_7th_date,
            'start_30th_date'=>$start_30th_date,
            'daily_sales_number'=>$daily_sales_number,
            'daily_sales_amount'=>$daily_sales_amount,
            'last_7_days_sales_number'=>$last_7_days_sales_number,
            'last_7_days_sales_amount'=>$last_7_days_sales_amount,
            'last_30_days_sales_number'=>$last_30_days_sales_number,
            'last_30_days_sales_amount'=>$last_30_days_sales_amount,
            'weekly_sales_datail'=>$weekly_sales_datails,
            'weekly_sales_number'=>$weekly_sales_number,
            'weekly_sales_amount'=>$weekly_sales_amount,
            'monthly_sales_number'=>$monthly_sales_number,
            'monthly_sales_amount'=>$monthly_sales_amount,
            'yearly_sales_number'=>$yearly_sales_number,
            'yearly_sales_amount'=>$yearly_sales_amount,
            'search_start_date'=>$search_start_date,
            'search_end_date'=>$search_end_date,
            'custom_search_sales_number'=>$custom_search_sales_number,
            'custom_search_sales_amount'=>$custom_search_sales_amount,
        ]);
    }

}
