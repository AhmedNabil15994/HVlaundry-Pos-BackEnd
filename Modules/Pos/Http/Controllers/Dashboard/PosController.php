<?php

namespace Modules\Pos\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Modules\Order\Entities\Order;


class PosController extends Controller
{

    function __construct()
    {
    }

    public function index()
    {
        $pickUpOrders = Order::where('payment_confirmed_at','!=',null)->whereHas('paymentStatus', function ($query) {
            $query->whereIn('flag', ['success','cash','subscriptions_balance','loyalty_points']);
        })->whereHas('orderTimes',function ($q) {
            $q->where('receiving_data->receiving_date','!=',null);
        })->count();

        $deliveryOrders = Order::where('payment_confirmed_at','!=',null)->whereHas('paymentStatus', function ($query) {
            $query->whereIn('flag', ['success','cash','subscriptions_balance','loyalty_points']);
        })->whereHas('orderTimes',function ($q) {
            $q->where('delivery_data->delivery_date','!=',null);
        })->count();

        $unPaidOrders = Order::whereNull('payment_confirmed_at')->count();
        $total =  Order::where('payment_confirmed_at','!=',null)->whereHas('paymentStatus', function ($query) {
            $query->whereIn('flag', ['success','cash','subscriptions_balance','loyalty_points']);
        })->sum('total');

        $monthlyOrders = $this->monthlyOrders();
        $totalThisMonth = Order::where('payment_confirmed_at','!=',null)->whereHas('paymentStatus', function ($query) {
            $query->whereIn('flag', ['success','cash','subscriptions_balance','loyalty_points']);
        })->whereBetween('payment_confirmed_at',[date('Y-m-01 00:00:00') , date('Y-m-t 23:59:59')])->sum('total');

        return view('pos::dashboard.index',compact('pickUpOrders','deliveryOrders','unPaidOrders','total','monthlyOrders','totalThisMonth'));
    }

    public function monthlyOrders()
    {
        $data["orders_dates"] = Order::where('payment_confirmed_at','!=',null)->whereHas('paymentStatus', function ($query) {
            $query->whereIn('flag', ['success','cash','subscriptions_balance','loyalty_points']);
        })->select(DB::raw("DATE_FORMAT(payment_confirmed_at,'%Y-%m') as date"))
            ->groupBy(DB::raw("DATE_FORMAT(payment_confirmed_at,'%Y-%m')"))
            ->pluck('date');

        $ordersIncome = Order::where('payment_confirmed_at','!=',null)->whereHas('paymentStatus', function ($query) {
            $query->whereIn('flag', ['success','cash','subscriptions_balance','loyalty_points']);
        })->select(DB::raw("sum(total) as profit"))
            ->groupBy(DB::raw("DATE_FORMAT(payment_confirmed_at, '%Y-%m')"))
            ->get();

        $data["profits"] = json_encode(array_column($ordersIncome->toArray(), 'profit'));

        return $data;
    }


}
