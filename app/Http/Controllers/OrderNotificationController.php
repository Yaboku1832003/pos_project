<?php
namespace App\Http\Controllers;

use App\Models\Order;

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

    //change read status to 1 start
    public function markAsRead()
    {
    Order::where('user_id', auth()->id())
        ->whereIn('status', [1, 2])
        ->where('readStatus', 0)
        ->update(['readStatus' => 1]);

    return response()->json(['success' => true]);
    }
    //change read status to 1 end

    public function myOrders(){
        dd('it works');
    }
}
