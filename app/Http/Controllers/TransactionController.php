<?php

namespace App\Http\Controllers;

use App\Models\Customers;
use App\Models\Orders;
use App\Models\PaymentPayfortLogs;
use App\Models\Products;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class TransactionController extends Controller
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
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
     */
    public function index()
    {
        return view('admin/transactions');
    }

    public function transaction_list()
    {
        $payfort_logs = Transaction::query()
            ->orderByDesc('id')
            ->get();
//        foreach($payfort_logs as $payfort) {
//            preg_match_all('/\[([^]]+)\] => ([^\r\n]+)\r?\n/', $payfort->messages, $matches);
//
//            $data[] = array_combine($matches[1], $matches[2]);
//
//            // Convert the array to stdClass object
//            //$myObject[] = (object)$data;
//
//        }
//        $myObject = (object)$data;
//        $trans_data = json_decode(json_encode($myObject));
        //dd($trans_data);
        return DataTables::of($payfort_logs)
            ->addColumn('action', function($row){
                return '<button class="btn btn-info btn-sm" data-id="'.$row->id.'"><i class="fa fa-eye text-xs"></i></button>';
            })
            ->toJson();
    }

    public function get_transaction(Request $request)
    {
        $trans_id = $request->transaction_id;
        $transaction_data = Transaction::find($trans_id);
        $data = [
            "data" => $transaction_data,
        ];
        return response()->json($data);
    }
}
