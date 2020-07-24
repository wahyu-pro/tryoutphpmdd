<?php

namespace App\Http\Controllers;

use App\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CustomerController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function index()
    {
        $customer = Customer::all();
        Log::info('CustomerControllerMethodIndex');
        return response()->json([
            "message" => "success retrieve data",
            "status" => true,
            "data" => $customer
        ], 200);
    }

    public function create(Request $request)
    {
        $customer = new Customer();
        $customer->full_name = $request->input('data.attributes.full_name');
        $customer->username = $request->input('data.attributes.username');
        $customer->email = $request->input('data.attributes.email');
        $customer->phone_number = $request->input('data.attributes.phone_number');
        $customer->save();

        Log::info('CustomerControllerMethodCreate');
        return response()->json(['message' => "Add data success"], 201);
    }

    public function findById($id)
    {
        $customer = Customer::find($id);
        if (!$customer) {
            return "Customer not found";
        }
        Log::info('CustomerControllerMethodFind');
        return response()->json([
            "message" => "success retrieve data",
            "status" => true,
            "data" => $customer
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $customer = Customer::find($id);
        if (!$customer) {
            return "Customer not found";
        }
        $customer->full_name = $request->input('data.attributes.full_name');
        $customer->username = $request->input('data.attributes.username');
        $customer->email = $request->input('data.attributes.email');
        $customer->phone_number = $request->input('data.attributes.phone_number');
        $customer->save();

        Log::info('CustomerControllerMethodUpdate');
        return response()->json(['message' => "Update data success"], 201);
    }

    public function delete($id)
    {
        $customer = Customer::find($id);
        if (!$customer) {
            return "Customer not found";
        }
        $customer->delete();
        Log::info('CustomerControllerMethodDelete');
        return response()->json(['message' => "Delete data success"], 201);
    }

}
