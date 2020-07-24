<?php

namespace App\Http\Controllers;

use App\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
// Configurations
use App\Http\Controllers\Midtrans\Config;

// Midtrans API Resources
use App\Http\Controllers\Midtrans\Transaction;

// Plumbing
use App\Http\Controllers\Midtrans\ApiRequestor;
use App\Http\Controllers\Midtrans\SnapApiRequestor;
use App\Http\Controllers\Midtrans\Notification;
use App\Http\Controllers\Midtrans\CoreApi;
use App\Http\Controllers\Midtrans\Snap;
use App\OrderItem;

class PaymentController extends Controller
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
        $result = Payment::all();

        Log::info('PaymentControllerMethodIndex');
        return response()->json([
            "message" => "success retrieve data",
            "status" => true,
            "data" => $result
        ], 200);
    }

    public function create(Request $request)
    {
        $payment = new Payment();
        $payment->payment_type = $request->input('data.attributes.payment_type');
        $payment->gross_amount = $request->input('data.attributes.gross_amount');
        // $payment->bank = $request->input('data.attributes.bank');
        $payment->transaction_id = 1243556;
        $payment->transaction_time = time();
        $payment->transaction_status = "Pending";
        $payment->order_id = $request->input('data.attributes.order_id');
        $payment->save();
        $id_payment = $payment->id;

        // Log::info('PaymentControllerMethodCreate');
        // return response()->json(['message' => "Add payment success"], 201);


        $paymentFind = Payment::find($id_payment);
        $item_list = array();
        $amount = 0;
        Config::$serverKey = 'SB-Mid-server-XNmbljytrWjbZS9Civ_JLQIh';
        if (!isset(Config::$serverKey)) {
            return "Please set your payment server key";
        }
        Config::$isSanitized = true;

        // Enable 3D-Secure
        Config::$is3ds = true;

        // Required

        $item_list[] = [
            'id' => "111",
            'price' => 20000,
            'quantity' => 1,
            'name' => "Majohn"
        ];

        $transaction_details = array(
            'order_id' => rand(),
            'gross_amount' => 20000, // no decimal allowed for creditcard
        );

        // Optional
        $item_details = $item_list;

        // Optional
        $billing_address = array(
            'first_name'    => "Andri",
            'last_name'     => "Litani",
            'address'       => "Mangga 20",
            'city'          => "Jakarta",
            'postal_code'   => "16602",
            'phone'         => "081122334455",
            'country_code'  => 'IDN'
        );

        // Optional
        $shipping_address = array(
            'first_name'    => "Obet",
            'last_name'     => "Supriadi",
            'address'       => "Manggis 90",
            'city'          => "Jakarta",
            'postal_code'   => "16601",
            'phone'         => "08113366345",
            'country_code'  => 'IDN'
        );

        // Optional
        $customer_details = array(
            'first_name'    => "Andri",
            'last_name'     => "Litani",
            'email'         => "andri@litani.com",
            'phone'         => "081122334455",
            'billing_address'  => $billing_address,
            'shipping_address' => $shipping_address
        );

        // Optional, remove this to display all available payment methods
        $enable_payments = array();

        // Fill transaction details
        $transaction = array(
            // 'enabled_payments' => $enable_payments,
            'transaction_details' => $transaction_details,
            'customer_details' => $customer_details,
            'item_details' => $item_details,
        );
        // return $transaction;
        try {
            $snapToken = Snap::getSnapToken($transaction);
            // return response()->json($snapToken);
            return response()->json($snapToken);
            // return ['code' => 1 , 'message' => 'success' , 'result' => $snapToken];
        } catch (\Exception $e) {
            dd($e);
            return ['code' => 0, 'message' => 'failed'];
        }
    }
}
