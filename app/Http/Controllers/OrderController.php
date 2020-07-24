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
        $order = Order::with(array('customer' => function ($query) {
            $query->select();
        }))->with(array('order_item' => function ($query) {
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
        // $order = new Order();
        // $order->user_id = $request->input('data.attributes.user_id');
        // $order->status = "pending";
        // $order->save();
        // $order_id = $order->id;

        // $request_detail = $request->input('data.attributes.order_detail');
        // for($i = 0; $i <= count($request_detail); $i++){
        //     $order_item = new OrderItem();
        //     $order_item->order_id = $order_id;
        //     $order_item->product_id = $request->input('data.attributes.order_detail.'.settype($i, 'string').'.product_id');
        //     $order_item->quantity = $request->input('data.attributes.order_detail.'.settype($i, 'string').'.quantity');
        //     $order_item->save();
        // }

        $request_data = $request->all();
        $order = new Order();
        $order->user_id = $request_data['data']['attributes']['user_id'];
        $order->order_status = 'create';
        $order->save();
        $data_product = $request_data['data']['attributes']['order_detail'];
        for ($i = 0; $i < count($data_product); $i++) {
            $product = new OrderItem();
            $product->order_id = $order->id;
            $product->product_id = $data_product[$i]['product_id'];
            $product->quantity = $data_product[$i]['quantity'];
            $product->save();
        }
        // return $request;
        Log::info('OrderControllerMethodCreate');
        return response()->json(['message' => "Add Order success"], 201);
    }

    public function findByid($id)
    {
        $result = Order::where('id', $id)->with(array('order_item' => function ($query) {
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
