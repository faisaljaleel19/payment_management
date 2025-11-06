<?php

namespace App\Http\Controllers;

use App\Lib\Payfort;
use App\Mail\payment_email_template;
use App\Models\CustomerAddress;
use App\Models\Customers;
use App\Models\Orders;
use App\Models\OrderStatus;
use App\Models\PaymentLink;
use App\Models\Products;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Propaganistas\LaravelPhone\PhoneNumber;
use Symfony\Component\Mailer\Exception\TransportException;
use Yajra\DataTables\Facades\DataTables;

class OrderController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('admin/orders');
    }

    public function order_list()
    {
        $model = Orders::join('customers', 'customers.id', '=', 'orders.customer_id')
            ->join('order_status', 'orders.order_id', '=','order_status.order_id')
            ->join('products', 'orders.order_id', '=', 'products.order_id')
            ->join('payment_link', 'orders.order_id', '=', 'payment_link.order_id')
            ->groupBy('orders.id','orders.order_id', 'orders.order_date', 'customers.first_name', 'customers.last_name', 'orders.currency', 'order_status.order_status_text', 'payment_link.expiry_date')
            ->select('orders.id','orders.order_id AS order_number', 'customers.first_name', 'customers.last_name', 'customers.email', 'order_status.order_status_text', 'payment_link.expiry_date',
                DB::raw('SUM(products.product_quantity) AS total_quantity'),
                DB::raw('SUM(products.product_quantity * products.product_price) AS total_price'))
            ->orderBy('orders.id', 'desc')
            ->get();
        return DataTables::of($model)
            ->addColumn('full_name', function($row){
                return $row->first_name.' '.$row->last_name;
            })
            ->addColumn('expiry_status', function($row){
                $today = Carbon::now('Asia/Dubai');
                $expiry_date = Carbon::parse($row->expiry_date);
                //$futureDateTime = $today->copy()->addHours(24);
                if($row->order_status_text === 'Completed') { return '-'; }
                else {
                    if ($expiry_date->diffInHours($today) > 24) {
                        return '<span class="badge badge-danger">Link Expired</span>';
                    } else {
                        return '<span class="badge badge-success">Active</span>';
                    }
                }
            })
            ->addColumn('action', function($row){
                return '<button class="btn btn-primary" data-order-id="'.$row->id.'">Open</button>';
            })
            ->rawColumns(['expiry_status', 'action'])
            ->toJson();
    }

    public function add_order(Request $request)
    {
        $customer_id = $request->customer_id;
        $customers = Customers::where('id','=',$customer_id)->first();
        $customer_address = CustomerAddress::where('customer_id', '=', $customers->id)->get();
        return view('admin/add_orders', compact('customers', 'customer_address'));
    }

    public function create_order(Request $request)
    {
        $validated = $request->validate([
            'customer_details' => 'required',
            'first_name' => 'required',
            'last_name' => 'required',
            'street_address1' => 'required',
            'city' => 'required',
            'country' => 'required',
            'zip_code' => 'required',
            'phone_number' => 'required|phone:AE,QA,BH,OM,SA,KW',
            'currency' => 'required'
        ]);

        $street_address1 = $request->input('street_address1');
        $street_address2 = $request->input('street_address2');
        $street_address3 = $request->input('street_address3');
        $city = $request->input('city');
        $state = $request->input('state');
        $country = $request->input('country');
        $zip_code = $request->input('zip_code');
        //$country_get = $request->input('country');

        //$order_id = 'MI'.date('Ymd').time();
        $customer_id = $request->input('customer_id');
        $orders = new orders([
            'order_date' => date('Y-m-d H:i:s'),
            'customer_id' => $customer_id,
            'customer_address_id' => $request->input('customer_details'),
            'currency' => $request->input('currency'),
            'remarks' => $request->input('remarks'),
            'created_by' => auth()->user()->id
        ]);

        if($orders->save())
        {
            $prefix = 'MI'.date('Ym');
            $orderNumber = str_pad($orders->id, 5, '0', STR_PAD_LEFT);

            $order_id = $prefix . $orderNumber;
            $order_id_update = Orders::find($orders->id);
            $order_id_update->order_id = $order_id;
            $order_id_update->save();

            $custom_address = CustomerAddress::find($request->input('customer_details'));

            $custom_address->street_address1 = $request->input('street_address1');
            if($request->filled('street_address2'))
            {
                $custom_address->street_address2 = $request->input('street_address2');
            }
            if($request->filled('street_address3'))
            {
                $custom_address->street_address2 = $request->input('street_address3');
            }
            if($request->filled('state'))
            {
                $custom_address->state = $request->input('state');
            }
            $custom_address->city = $request->input('city');
            $custom_address->country = $request->input('country');
            $custom_address->zip_code = $request->input('zip_code');
            $country_get = $request->input('country');
            if($country_get == 'United Arab Emirates')
            {
                $country_code = 'AE';
            }
            elseif($country_get == 'Saudi Arabia')
            {
                $country_code = 'SA';
            }
            elseif($country_get == 'Qatar')
            {
                $country_code = 'QA';
            }
            elseif($country_get == 'Bahrain')
            {
                $country_code = 'BH';
            }
            elseif($country_get == 'Oman')
            {
                $country_code = 'OM';
            }
            elseif($country_get == 'Kuwait')
            {
                $country_code = 'KW';
            }
            else
            {
                $country_code = 'AE';
            }
            $phone = new PhoneNumber($request->input('phone_number'), $country_code);
            $formatted_phone = $phone->formatE164();
            $custom_address->phone_number = $formatted_phone;

            $custom_address->save();
            $product_name = $request->input('product_name');
            $product_desc = $request->input('product_description');
            $product_price = $request->input('product_price');
            $product_quantity = $request->input('product_quantity');
            for($i = 0; $i<count($product_name) ; $i++)
            {
                $product = new Products([
                    'order_id' => $order_id,
                    'product_name' => $product_name[$i],
                    'product_description' => $product_desc[$i],
                    'product_price' => $product_price[$i],
                    'product_quantity' => $product_quantity[$i]
                ]);
                $product->save();
            }
            $insert_status = new OrderStatus([
                'order_id' => $order_id,
                'order_status_text' => 'Pending'
            ]);
            $token = (string) Str::uuid();
            $create_payment_link = new PaymentLink([
               'order_id' => $order_id,
               'token' => $token,
                'expiry_date' => Carbon::now('Asia/Dubai')->addDay()->format('Y-m-d H:i:s')
            ]);
            //$insert_status = DB::insert('insert into order_status (order_id, order_status_text) values (?, ?)', [$order_id, 'Pending']);
            if(($insert_status->save()) && ($create_payment_link->save()))
            {
                $customer_data = Customers::find($customer_id);
                $customer_name = $request->input('first_name').' '.$request->input('last_name');
                $order_date = date('Y-m-d H:i:s');
                $payment_link = 'https://resource.moreideas.ae/payment_mi/pay?mi='.$token;
                $order_date_format = Carbon::parse($order_date)->format('F j, Y, h:i:s A');
                $template = new payment_email_template($customer_name, $order_id, $order_date_format, $street_address1, $street_address2, $street_address3, $city, $state, $country, $zip_code, $formatted_phone, $payment_link);
                try{
                    Mail::to($customer_data->email)->send($template);
                } catch(TransportException $e) {
                    dd($e);
                }
                return redirect()->route('orders')->with('success', 'Order Added Successfully');
            }
        }
        return redirect()->route('add_order', ['customer_id' => $customer_id])->with('error', 'Error Occurred While creating order');
    }

    public function view_order(Request $request)
    {
        if($request->filled('order_id')) {
            $order_id = $request->input('order_id');
            $order = Orders::find($order_id);
            $products = Products::where('order_id', '=', $order->order_id)->get();
            $customer = Customers::find($order->customer_id);
            $customer_address = CustomerAddress::find($order->customer_address_id);
            $order_status = OrderStatus::where('order_id', '=', $order->order_id)->get();
            $payment_link = PaymentLink::where('order_id', '=', $order->order_id)->first();
            return view('admin/view_order', compact('order', 'products', 'customer', 'customer_address', 'order_status', 'payment_link'));
        }
        else
        {
            return redirect()->route('dashboard');
        }
    }

    public function resend_payment_link(Request $request)
    {
        $order_id = $request->input('order_id');
        $customer_name = $request->input('customer_name');
        $customer_email = $request->input('customer_email');
        $order_date = $request->input('order_date');
        $street_address1 = $request->input('street_address1');
        $street_address2 = $request->input('street_address2');
        $street_address3 = $request->input('street_address3');
        $city = $request->input('city');
        $state = $request->input('state');
        $country = $request->input('country');
        $zip_code = $request->input('zip_code');
        $phone = $request->input('phone_number');
        $payment_link = $request->input('payment_link');
        $payment_link_data = PaymentLink::where('order_id', '=', $order_id)->first();
        $today = Carbon::now('Asia/Dubai');
        $expiry_date = Carbon::parse($payment_link_data->expiry_date);
        $mail_sent = false;
        //$futureDateTime = $today->copy()->addHours(24);
        if($expiry_date->diffInHours($today) > 24) {
            $expired = true;
        }
        else
        {
            $expired = false;
            $order_expiry = Carbon::parse($payment_link_data->expiry_date)->format('F, d Y h:i:s A');
        }
        if(!$expired)
        {
            $template = new payment_email_template($customer_name, $order_id, $order_date, $street_address1, $street_address2, $street_address3, $city, $state, $country, $zip_code, $phone, $payment_link);
            try{
                Mail::to($customer_email)->send($template);
                $mail_sent = true;
            } catch(TransportException $e) {
                //dd($e);
            }
            $data = [
                "status" => $mail_sent,
                "expired" => false
            ];
        }
        else
        {
            $data = [
                "status" => false,
                "expired" => true
            ];
        }
        return response()->json($data);
    }

    public function payment_link(Request $request)
    {
        if($request->filled('mi')) {
            $token = $request->input('mi');
            $payment = PaymentLink::where('token', '=', $token)->first();
            if($payment) {
                $today = Carbon::now('Asia/Dubai');
                $expiry_date = Carbon::parse($payment->expiry_date);
                if($expiry_date->diffInHours($today) > 24) {
                    $expired = true;
                    return view('payment_link', compact('expired'));
                }
                else
                {
                    $expired = false;
                    $order = Orders::where('order_id', '=', $payment->order_id)->first();
                    $customer = Customers::find($order->customer_id);
                    $customer_address = CustomerAddress::where('customer_id', '=', $customer->id)->first();
                    $product = Products::where('order_id', '=', $order->order_id)->get();
                    $product_details = Orders::join('products', 'orders.order_id', '=', 'products.order_id')
                        ->groupBy('orders.id', 'orders.order_id', 'orders.order_date', 'orders.currency')
                        ->select('orders.id', 'orders.order_id AS order_number',
                            DB::raw('SUM(products.product_quantity) AS total_quantity'),
                            DB::raw('SUM(products.product_quantity * products.product_price) AS total_price'))
                        ->where('orders.order_id', '=', $order->order_id)
                        ->first();
                    $order_status = OrderStatus::where('order_id', '=', $order->order_id)->first();
                    return view('payment_link', compact('order', 'customer', 'product', 'order_status', 'customer_address', 'product_details', 'expired'));
                }
            }
            else
            {
                return view('not_found');
            }
        }
        else
        {
            return view('not_found');
        }
    }

    public function payment_route(Request $request)
    {
        if(!isset($request->r)) {
            return 'Page Not Found!';
        }
        $objFort = new Payfort();
        if($request->r == 'getPaymentPage') {
            return $objFort->processRequest(htmlspecialchars($request->paymentMethod, ENT_QUOTES, 'UTF-8'), $request->amt,  $request->currency, $request->email, $request->order);
        }
        elseif($request->r == 'merchantPageReturn') {
            return $objFort->processMerchantPageResponse();
        }
        elseif($request->r == 'processResponse') {
            return $objFort->processResponse();
        }
        else{
            return 'Page Not Found!';
        }
    }

    public function success_payment(Request $request)
    {
        $success_msg = $request->response_message;
        if($success_msg === 'Success') {
            $order_id = $request->merchant_reference;
            $orders = Orders::where('order_id', '=', $order_id)->first();
            $order_status_update = OrderStatus::where('order_id', '=', $order_id)->first();
            $order_status_update->order_status_text = "Completed";
            $order_status_update->save();
            $customer = Customers::find($orders->customer_id);
            $product_details = Orders::join('products', 'orders.order_id', '=', 'products.order_id')
                ->groupBy('orders.id', 'orders.order_id', 'orders.order_date', 'orders.currency')
                ->select('orders.id', 'orders.order_id AS order_number',
                    DB::raw('SUM(products.product_quantity) AS total_quantity'),
                    DB::raw('SUM(products.product_quantity * products.product_price) AS total_price'))
                ->where('orders.order_id', '=', $orders->order_id)
                ->first();
            $fail = false;
            return view('success_pay', compact('orders', 'customer', 'product_details', 'fail'));
        }
        else if($success_msg === 'Transaction declined')
        {
            $order_id = $request->merchant_reference;
            $orders = Orders::where('order_id', '=', $order_id)->first();
            $order_status_update = OrderStatus::where('order_id', '=', $order_id)->first();
            $order_status_update->order_status_text = "Transaction Declined";
            $order_status_update->save();
            $fail = true;
            $message = 'Transaction Declined';
            return view('success_pay', compact('fail', 'message'));
        }
        else
        {
            $fail = true;
            return view('success_pay', compact('fail'));
        }
    }

    public function error_payment(Request $request)
    {
        $error_msg = $request->response_message;
            $order_id = $request->merchant_reference;
            $orders = Orders::where('order_id', '=', $order_id)->first();
            $order_status_update = OrderStatus::where('order_id', '=', $order_id)->first();
            $order_status_update->order_status_text = "Failed";
            $order_status_update->save();
            $customer = Customers::find($orders->customer_id);
            $product_details = Orders::join('products', 'orders.order_id', '=', 'products.order_id')
                ->groupBy('orders.id', 'orders.order_id', 'orders.order_date', 'orders.currency')
                ->select('orders.id', 'orders.order_id AS order_number',
                    DB::raw('SUM(products.product_quantity) AS total_quantity'),
                    DB::raw('SUM(products.product_quantity * products.product_price) AS total_price'))
                ->where('orders.order_id', '=', $orders->order_id)
                ->first();
            return view('error_pay', compact('orders', 'customer', 'product_details', 'error_msg'));
    }

    public function check_expiry(Request $request)
    {
        $order_id = $request->order_id;
        $order_expiry = '';
        $payment_link = PaymentLink::where('order_id', '=', $order_id)->first();
        $today = Carbon::now('Asia/Dubai');
        $expiry_date = Carbon::parse($payment_link->expiry_date);
        //$futureDateTime = $today->copy()->addHours(24);
        if($expiry_date->diffInHours($today) > 24) {
            $expired = true;
        }
        else
        {
            $expired = false;
            $order_expiry = Carbon::parse($payment_link->expiry_date)->format('F, d Y h:i:s A');
        }

        $data = [
            "status" => true,
            "order_expiry" => $order_expiry,
            "expired_status" => $expired,
        ];
        return response()->json($data);
    }

    public function reactivate_order(Request $request)
    {
        $order_id = $request->order_id;
        $today = Carbon::now('Asia/Dubai')->format('Y-m-d H:i:s');
        $payment_link = PaymentLink::where('order_id', '=', $order_id)->first();
        $payment_link->expiry_date = $today;
        if($payment_link->save())
        {
            $status = true;
        }
        else
        {
            $status = false;
        }
        $data = [
            "status" => $status,
        ];
        return response()->json($data);
    }

    public function change_status_order(Request $request)
    {
        $order_id = $request->order_id;
        $status_text = $request->status_text;
        $change_status = OrderStatus::query()->where('order_id', '=', $order_id)->first();
        $change_status->order_status_text = $status_text;
        if($change_status->save())
        {
            $data = [
              "status" => true
            ];
        }
        else
        {
            $data = [
                "status" => false
            ];
        }
        return response()->json($data);
    }
}
