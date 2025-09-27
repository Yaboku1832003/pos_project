<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\PaymentHistory;

class OrderController extends Controller
{
    //direct to order list
    public function orderList(){
        $orderList = Order::select('orders.id','orders.order_code','orders.user_id','orders.created_at','orders.status',
                                'users.name','products.stock','orders.count',)
                    ->leftJoin('users','orders.user_id','users.id')
                    ->leftJoin('products','orders.product_id','products.id')
                    ->groupBy('order_code')
                    ->orderBy('orders.created_at', 'desc')
                    ->paginate(6);
                    // dd($orderList->toArray());

        return view('admin.order.orderList',compact('orderList'));
    }

    public function orderDetails($orderCode){
        $order = Order::select('orders.id as order_id','orders.count as order_count','orders.order_code','orders.created_at','orders.status',
                                'products.id as product_id','products.image','products.sale_price','products.stock','products.name as product_name',
                                'users.name as user_name','users.phone','users.address')
                        ->leftJoin('products','orders.product_id','products.id')
                        ->leftJoin('users','orders.user_id','users.id')
                        ->where('order_code',$orderCode)
                        ->paginate(3);

        $paymentHistory = PaymentHistory::select('payment_histories.phone','payment_histories.address','payment_histories.payment_voucher',
                                                'payment_histories.final_total','payment_histories.created_at','payments.type as payment_type')
                                        ->where('order_code',$orderCode)
                                        ->leftJoin('payments','payment_histories.payment_type','payments.id')
                                        ->first();
        $status = true;

        foreach ($order as $item) {
            if( $item->order_count <= $item->stock && $item->status == 0){
                $status = true;
            }else{
                $status = false;
                break;
            }
        }
        return view('admin.order.orderDetails',compact('order','paymentHistory','status'));
    }

    public function orderConfirm(Request $request){
        // logger($request->all());
        Order::where('order_code', $request[0]['order_code'])
            ->update(['status' => 1]);

        foreach ($request->all() as $items) {
        Product::where('id', $items['product_id'])
                ->decrement('stock', $items['count']);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'order confirmed'
        ],200);
    }

    public function orderReject(Request $request){
        // logger($request->all());
        Order::where('order_code', $request->order_code)
            ->update(['status' => 2]);

        return response()->json([
            'status' => 'success',
            'message' => 'order rejected'
        ],200);
    }
}
