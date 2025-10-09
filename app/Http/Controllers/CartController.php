<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\User;
use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\Request;
use App\Models\PaymentHistory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    public function addToCart(Request $request)
    {
        $userId    = Auth::user()->id;
        $productId = $request->productId;
        $quantity  = $request->quantity;
        // Check if cart already has this product
        $cart = Cart::where('user_id', $userId)
            ->where('product_id', $productId)
            ->first();
        if ($cart) {
            // Increase existing quantity
            $cart->qty += $quantity;
            $cart->save();
        } else {
            // Create a new cart item
            Cart::create([
                'user_id'    => $userId,
                'product_id' => $productId,
                'qty'        => $quantity,
            ]);
        }
        return redirect()->back();
    }

    // show profile and products in cart page
    public function goToCart(Request $request)
    {
        $profile = User::select('users.id', 'users.name', 'users.profile', 'users.created_at')
            ->where('id', Auth::user()->id)
            ->first();

        $cartData = Cart::select('carts.id as cart_id', 'carts.qty', 'carts.user_id',
            'products.id as product_id', 'products.image', 'products.name', 'products.sale_price', 'products.stock')
            ->leftJoin('products', 'carts.product_id', 'products.id')
            ->where('carts.user_id', Auth::user()->id)
            ->get();
        $totalPrice = 0;
        foreach ($cartData as $data) {
            $totalPrice += $data->sale_price * $data->qty;
        }

        // $orderHistory = Order::where('user_id',Auth::user()->id)
        //                     ->groupBy('order_code')
        //                     ->orderBy('created_at',"desc")
        //                     ->get();

        // Pending orders
        $pendingOrders = Order::select('orders.order_code','orders.created_at','orders.status')
                            ->where('user_id', Auth::user()->id)
                            ->where('status', 0)
                            ->groupBy('order_code')
                            ->orderBy('created_at', 'desc')
                            ->paginate(9, ['*'], 'pendingPage');
                    // use separate page name

        // Other orders (accepted/rejected)
        $otherOrders = Order::select('orders.order_code','orders.created_at','orders.status')
                            ->where('user_id', Auth::user()->id)
                            ->whereIn('status', [1,2])
                            ->groupBy('order_code')
                            ->orderBy('created_at', 'desc')
                            ->paginate(9, ['*'], 'otherPage');

        return view('user.home.cart', compact('cartData', "profile", "totalPrice",'pendingOrders','otherOrders'));
    }
    public function orderDetails($orderCode){
        $order = Order::select('orders.id as order_id','orders.count as order_count','orders.order_code','orders.created_at','orders.status',
                                'products.id as product_id','products.image','products.sale_price','products.stock','products.name as product_name',)
                        ->leftJoin('products','orders.product_id','products.id')
                        ->where('order_code',$orderCode)
                        ->paginate(6);
        $paymentHistory = PaymentHistory::select('payment_histories.phone','payment_histories.address','payment_histories.payment_voucher',
                                                'payment_histories.final_total','payment_histories.created_at','payments.type as payment_type')
                                        ->where('order_code',$orderCode)
                                        ->leftJoin('payments','payment_histories.payment_type','payments.id')
                                        ->first();
                        // dd($order->toArray());
                return view('user.home.orderDetail',compact('order','paymentHistory'));
    }
    // delete item from cart
    public function cartDelete(Request $request)
    {
        $cartData = $request->cartId;
        // logger($cartData);
        Cart::where('id', $cartData)->delete();

        return response()->json([
            'status'  => 'success',
            'message' => 'cart deleted successfully',
        ], 200);
    }

    //qty update before leave url
    public function cartUpdate(Request $request)
    {
        $cartUpdates = $request->data;
        if ($cartUpdates) {
            foreach ($cartUpdates as $item) {
                Cart::whereId($item['cartId'])->update(['qty' => $item['quantity']]);
            }
            return response()->json([
                'status'  => 'success',
                'message' => 'Cart updated successfully',
            ], 200);
        }
    }
    //temporary store order data
    public function tempStorage(Request $request){
        // logger($request->all());
        $orderTemp = [];
        foreach ($request->all() as $data) {
            array_push($orderTemp,[
                //name from db table <-> name from the jQuery
                'product_id' => $data['product_id'],
                'user_id' => $data['user_id'],
                'count' => $data['count'],
                'status' => $data['status'],
                'order_code' => $data['order_code'],
                'subTotal' => $data['subTotal']
            ]);
        }
        // logger($orderTemp);
        Session::put('tempCart', $orderTemp);

        return response()->json([
                'status'  => 'success',
                'message' => 'Successfully store in session.',
            ], 200);
    }

    //direct to payment page
    public function paymentPage()
    {
        $orderTemp = Session::get('tempCart');
        $paymentAcc = Payment::select('id as payment_id','account_name','account_number','type')->orderBy('type','asc')->get();
        $products = Cart::select('carts.qty', 'carts.user_id', 'products.image',
                            'products.name', 'products.sale_price')
            ->leftJoin('products', 'carts.product_id', 'products.id')
            ->where('carts.user_id', Auth::user()->id)
            ->get();
        // dd($products->toArray());
        return view('user.home.paymentPage',compact('paymentAcc','orderTemp','products'));
    }
}
