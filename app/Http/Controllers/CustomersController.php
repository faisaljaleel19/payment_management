<?php

namespace App\Http\Controllers;

use App\Models\CustomerAddress;
use App\Models\Customers;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Propaganistas\LaravelPhone\PhoneNumber;
use Yajra\DataTables\Facades\DataTables;

class CustomersController extends Controller
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
    public function index()
    {
        return view('admin/customers');
    }

    public function customer_list()
    {
        $model = Customers::query();

        return DataTables::of($model)
            ->addColumn('full_name', function($row){
                return $row->first_name.' '.$row->last_name;
            })
            ->addColumn('action', function($row){
                $action = '<button class="btn btn-secondary btn-sm" data-edit-id="'.$row->id.'"><i class="fa fa-pencil"></i></button>&nbsp;&nbsp;&nbsp;';
                $action .= '<button class="btn btn-info btn-sm" data-customer-id="'.$row->id.'">Create Order for this customer</button>';
                return $action;
            })
            ->toJson();
    }

    public function add_customer()
    {
        return view('admin/add_customer');
    }

    public function create_customer(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'first_name' => 'required',
            'email' => 'required|email:rfc,dns|unique:customers',
            'gender' => 'required',
            'street_address1' => 'required',
            'city' => 'required',
            'country' => 'required',
            'zip_code' => 'required',
            'phone_number' => 'required'
        ]);

        $customer = new Customers([
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
            'email' => $request->input('email'),
            'gender' => $request->input('gender'),
        ]);

        if($customer->save()) {
            $customer_id = $customer->id;
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
            else
            {
                $country_code = 'AE';
            }
            $phone = new PhoneNumber($request->input('phone_number'), $country_code);
            $formatted_phone = $phone->formatE164();
            $customer_address = new CustomerAddress([
                'customer_id' => $customer_id,
                'street_address1' => $request->input('street_address1'),
                'street_address2' => $request->input('street_address2'),
                'street_address3' => $request->input('street_address3'),
                'city' => $request->input('city'),
                'state' => $request->input('state'),
                'country' => $country_get,
                'zip_code' => $request->input('zip_code'),
                'phone_number' => $formatted_phone
            ]);
            if($customer_address->save()) {
                return redirect()->route('customers')->with('success', 'Customer Added Successfully');
            }
            return redirect()->route('add_customer')->with('error', 'Error Occurred while adding');
        }

        return redirect()->route('add_customer')->with('error', 'Error Occurred while adding');

    }

    public function get_customer(Request $request)
    {
        if($request->input('id'))
        {
            $customer_data = Customers::find($request->input('id'));
            $customer_address_data = CustomerAddress::query()->where('customer_id', $request->input('id'))->get();
            if($customer_data && $customer_address_data)
            {
                $response = array(
                    'status' => true,
                    'first_name' => $customer_data->first_name,
                    'last_name' => $customer_data->last_name,
                    'email' => $customer_data->email,
                    'gender' => $customer_data->gender,
                    'street_address1' => $customer_address_data[0]->street_address1,
                    'street_address2' => $customer_address_data[0]->street_address2,
                    'street_address3' => $customer_address_data[0]->street_address3,
                    'city' => $customer_address_data[0]->city,
                    'state' => $customer_address_data[0]->state,
                    'country' => $customer_address_data[0]->country,
                    'zip_code' => $customer_address_data[0]->zip_code,
                    'phone_number' => $customer_address_data[0]->phone_number
                );
                return response()->json($response);
            }
            else
            {
                return response()->json(['status' => false]);
            }
        }
        return response()->json(['status' => false]);
    }

    public function update_customer(Request $request)
    {
        if($request->input('customer_id'))
        {
            $customer_id = $request->input('customer_id');
            $first_name = $request->input('first_name');
            $last_name = $request->input('last_name');
            $gender = $request->input('gender');
            $email = $request->input('email');
            $street_address1 = $request->input('street_address1');
            $street_address2 = $request->input('street_address2');
            $street_address3 = $request->input('street_address3');
            $city = $request->input('city');
            $state = $request->input('state');
            $country = $request->input('country');
            $zip_code = $request->input('zip_code');
            $phone_number = $request->input('phone_number');

            $customer_data = Customers::find($customer_id);
            $checkEmailExist = Customers::where('email', $email)->get()->count();
            if($checkEmailExist === 0) {
                $customer_data->first_name = $first_name;
                $customer_data->last_name = $last_name;
                $customer_data->email = $email;
                $customer_data->gender = $gender;
                $customer_address_data = CustomerAddress::where('customer_id', $customer_id)->first();
                $customer_address_data->street_address1 = $street_address1;
                $customer_address_data->street_address2 = $street_address2;
                $customer_address_data->street_address3 = $street_address3;
                $customer_address_data->city = $city;
                $customer_address_data->state = $state;
                $customer_address_data->country = $country;
                $customer_address_data->zip_code = $zip_code;
                $customer_address_data->phone_number = $phone_number;
                if ($customer_data->save() && $customer_address_data->save()) {
                    return response()->json(['status' => true]);
                } else {
                    return response()->json(['status' => false]);
                }
            }
            else
            {
                return response()->json(['status' => false, 'message' => 'Entered email is belong to another customer']);
            }
        }
        return response()->json(['status' => false]);
    }
}
