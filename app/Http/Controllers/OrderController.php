<?php

namespace App\Http\Controllers;
use App\Order;
use App\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
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
        // $customer = Order::all();
        $order = Order::with(array('customer' => function($query){
            $query->select();
        }))->with(array('order_item' => function($query){
            $query->select();
        }))->get();
        Log::info('OrderControllerMethodIndex');
        return response()->json([
            "message" => "success retrieve data",
            "status" => true,
            "data" => $order
        ], 200);
    }

    public function create(Request $request)
    {
        $order = new Order();
        $order->user_id = $request->input('data.attributes.user_id');
        $order->status = "pending";
        $order->save();
        $order_id = $order->id;

        $request_detail = $request->input('data.attributes.order_detail');
        for($i = 0; $i <= count($request_detail); $i++){
            $order_item = new OrderItem();
            $order_item->order_id = $order_id;
            $order_item->product_id = $request->input('data.attributes.order_detail.'.settype($i, 'string').'.product_id');
            $order_item->quantity = $request->input('data.attributes.order_detail.'.settype($i, 'string').'.quantity');
            $order_item->save();
        }
        Log::info('OrderControllerMethodCreate');
        return response()->json(['message' => "Add Order success"], 201);
    }

    public function findByid($id)
    {
        $result = Order::where('id', $id)->with(array('order_item' => function($query){
            $query->select();
        }))->get();

        if (!$result) {
            return "Order not found";
        }

        return response()->json([
            "message" => "success retrieve data",
            "status" => true,
            "data" => $result
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $order = Order::find($id);
        $order->user_id = $request->input('data.attributes.user_id');
        $order->status = "pending";
        $order->save();
        $order_id = $order->id;

        if (!$order) {
            return "Order not found";
        }

        return response()->json(['message' => 'update success']);
    }

    public function delete($id)
    {
        $order = Order::find($id);
        $order->delete();

        $order_item = OrderItem::where('order_id', $id)->delete();
        // $order_item->delete();
        return response()->json(['message' => $order_item]);
    }
}
