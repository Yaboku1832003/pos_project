<?php
namespace App\Http\Controllers;

use App\Models\Order;

class OrderNotificationController extends Controller
{
    //
    public function getNotificationCount()
    {
        $count = Order::whereIn('status', [1, 2])
            ->where('readStatus', 0)
            ->groupBy('order_code')
            ->get()
            ->count();

        return response()->json(['count' => $count]);
    }

    public function markAsRead()
    {
    Order::whereIn('status', [1, 2])
        ->where('readStatus', 0)
        ->update(['readStatus' => 1]);

    return response()->json(['success' => true]);
    }

    public function myOrders(){
        dd('it works');
    }
}
