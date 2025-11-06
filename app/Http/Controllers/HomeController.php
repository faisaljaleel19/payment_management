<?php

namespace App\Http\Controllers;

use AmrShawky\LaravelCurrency\Facade\Currency;
use App\Models\Customers;
use App\Models\Orders;
use App\Models\Products;
use Carbon\Carbon;
use Illuminate\Http\Request;

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
    public function index(): \Illuminate\Contracts\Support\Renderable
    {
        $order_count = count(Orders::all());
        $customer_count = count(Customers::all());
        return view('admin/dashboard', compact('order_count', 'customer_count'));
    }

    public function total_transactions(): \Illuminate\Http\JsonResponse
    {
        $total = 0;
        $all_dates = [];
        $product_price = [];
        $orders = Orders::join('order_status', 'orders.order_id', '=', 'order_status.order_id')->where('order_status.order_status_text', '=', 'Completed')->get();
        foreach($orders as $or)
        {
            $all_dates[] = Carbon::parse($or->created_at)->format('M j');
            $product = Products::query()->whereDate('created_at', '=', $or->created_at)->first();

            if($or->currency === 'AED')
            {
                $prod_price = $product->product_price;
            }
            else {
                $prod_price = Currency::convert()
                    ->from($or->currency)
                    ->to('AED')
                    ->amount($product->product_price)
                    ->round(1)
                    ->get();
            }
            $product_price[] = $prod_price;
            $total = $total + $prod_price;
        }
        $data = array(
            'status' => true,
            'all_dates' => $all_dates,
            'product_price' => $product_price,
            'total' => round($total)
        );
        return response()->json($data);
    }
}
