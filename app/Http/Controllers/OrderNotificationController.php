<?php
namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderNotificationController extends Controller
{
    //show the order count where read status is 0 start
    public function getNotificationCount()
    {
        $count = Order::where('user_id', auth()->id())
            ->whereIn('status', [1, 2])
            ->where('readStatus', 0)
            ->groupBy('order_code')
            ->get()
            ->count();

        return response()->json(['count' => $count]);
    }
    //show the order count where read status is 0 end

    // Mark all notifications as read
    public function markAllRead()
    {

        $orders = Order::where('user_id', Auth::user()->id)
            ->whereIn('status', [1, 2])
            ->where('readStatus', 0)
            ->get();

        foreach ($orders as $order) {
            $order->timestamps = false;
            $order->readStatus = 1;
            $order->save();
        }

        return response()->json(['success' => true]);
    }

    public function markSingleRead(Request $request)
    {
        $orderCode = $request->order_code;

        $orders = Order::where('user_id',Auth::user()->id)
            ->where('order_code', $orderCode)
            ->where('readStatus', 0)
            ->get();

        foreach ($orders as $order) {
            $order->timestamps = false;
            $order->readStatus = 1;
            $order->save();
        }

        return response()->json(['success' => true]);
    }

    public function myNotifications()
    {
        $orders = Order::select('orders.order_code', 'orders.updated_at', 'orders.status', 'orders.readStatus')
            ->where('user_id', Auth::user()->id)
            ->whereIn('status', [1, 2])
            ->groupBy('order_code')
            ->orderBy('created_at', 'desc')
            ->paginate(9, ['*'], 'otherPage');

        // Total unread notifications
        $unreadCount = Order::where('user_id', Auth::user()->id)
            ->whereIn('status', [1, 2])
            ->where('readStatus', 0)
            ->distinct('order_code')
            ->count();
        return view('user.home.notification', compact('orders', 'unreadCount'));
    }
}
