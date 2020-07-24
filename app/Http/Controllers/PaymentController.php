<?php

namespace App\Http\Controllers;
use App\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

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
        $payment->bank = $request->input('data.attributes.bank');
        $payment->order_id = $request->input('data.attributes.order_id');

        $payment->save();
    }

}
