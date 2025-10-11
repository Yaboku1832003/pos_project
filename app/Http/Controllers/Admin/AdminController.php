<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Payment;
use App\Models\PaymentHistory;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use RealRashid\SweetAlert\Facades\Alert;

class AdminController extends Controller
{
    //admin dashboard
    public function dashboard(Request $request)
    {
        //Get selected month from request, default to current month
        $filterMonth = $request->input('month', date('Y-m'));

        //Monthly totals
        $monthlyTotals = Order::leftJoin('products', 'orders.product_id', 'products.id')
            ->where('orders.status', 1)
            ->whereRaw('DATE_FORMAT(orders.updated_at, "%Y-%m") = ?', [$filterMonth])
            ->selectRaw('
            SUM(orders.count * products.sale_price) as total_sale_price,
            SUM(orders.count * products.cost_price) as total_cost_price
        ')
            ->first();

        //Get all order codes
        $orderCodes = Order::where('status', 1)
            ->pluck('order_code');

        //Total payment for selected month
        $totalPayment = PaymentHistory::whereIn('order_code', $orderCodes)
            ->whereRaw('DATE_FORMAT(updated_at, "%Y-%m") = ?', [$filterMonth])
            ->selectRaw('SUM(final_total) as totalPayment')
            ->first();

        //Daily totals for selected month
        $dailyTotals = Order::leftJoin('products', 'orders.product_id', 'products.id')
            ->where('orders.status', 1)
            ->whereRaw('DATE_FORMAT(orders.updated_at, "%Y-%m") = ?', [$filterMonth])
            ->selectRaw('
            DATE_FORMAT(orders.updated_at, "%Y-%m-%d") as day,
            SUM(orders.count * products.sale_price) as total_sale_price,
            SUM(orders.count * products.cost_price) as total_cost_price
        ')
            ->groupBy('day')
            ->orderBy('day')
            ->get();

        $totalAcceptedOrders = PaymentHistory::whereRaw('DATE_FORMAT(updated_at, "%Y-%m") = ?', [$filterMonth])
                ->whereIn('order_code', $orderCodes)
                ->distinct('order_code')
                ->count('order_code');
        $totalRejectedOrders = PaymentHistory::join('orders', 'payment_histories.order_code', '=', 'orders.order_code')
    ->whereRaw('DATE_FORMAT(payment_histories.updated_at, "%Y-%m") = ?', [$filterMonth])
    ->where('orders.status', 2)
    ->distinct()
    ->count('payment_histories.order_code');
        //Pass everything to the view
        return view('admin.dashboard.mainDashboard', compact(
            'filterMonth',
            'monthlyTotals',
            'totalPayment',
            'dailyTotals',
            'totalAcceptedOrders',
            'totalRejectedOrders'

        ));
    }

    //create payment method page start
    public function createPaymentMethodPage()
    {
        //payment lists data conpact start
        $payments = Payment::all();
        return view('admin.payment.paymentMehod', compact('payments'));
        //payment lists data conpact end
    }
    //create payment method page end

    //payment create start
    public function createMethod(Request $request)
    {
        $this->validationCheck($request, 'create');

        Payment::create([
            'account_number' => $request->account_number,
            'account_name'   => $request->account_name,
            'type'           => $request->account_type,
        ]);
        Alert::success('Success Title', 'Created Payment Method Successfully');
        return back();
    }
    //payment create end

    //(private)  input validationCheck for payment method start
    private function validationCheck(Request $request, $action, $currentId = null)
    {
        $rules = [
            'account_type'   => 'required',
            'account_name'   => 'required',
            'account_number' => ['required'],
        ];

        if ($action === 'create') {
            // On create, account_number must be unique per account_type
            $rules['account_number'][] = Rule::unique('payments')
                ->where('type', $request->account_type);
        } elseif ($action === 'update' && $currentId) {
            // On update, validate uniqueness only if account_type or account_number changed

            // Fetch the existing payment record
            $payment = Payment::find($currentId);
            if (! $payment) {
                // If payment not found, just apply required rule (or handle as needed)
                $request->validate($rules);
                return;
            }

            $typeChanged   = $request->account_type !== $payment->type;
            $numberChanged = $request->account_number !== $payment->account_number;

            if ($typeChanged || $numberChanged) {
                $rules['account_number'][] = Rule::unique('payments')
                    ->where('type', $request->account_type)
                    ->ignore($currentId);
            }
        }

        $request->validate($rules);
    }

    //(private)  input validationCheck for payment method end

    //delete payment method start
    public function deleteMethod($id)
    {
        // dd($id);
        $payment = Payment::find($id);

        if ($payment) {
            $payment->delete();
        }
        return back();
    }
    //delete payment method end

    //edit payment method start
    public function editMethod($id)
    {
        $editPayment = Payment::find($id);
        // dd($editPayment->toArray());
        return view('admin.payment.editPaymentMethod', compact('editPayment'));
    }
    //edit payment method end

    //update payment method start
    public function updateMethod(Request $request, $id)
    {
        // Find the payment record by id
        $payment = Payment::find($id);

        if (! $payment) {
            return back()->with('error', 'Payment record not found');
        }

        // Validate input - pass $id for uniqueness ignore
        $this->validationCheck($request, 'update', $id);

        Payment::where('id', $payment->id)
            ->update([
                'account_number' => $request->account_number,
                'account_name'   => $request->account_name,
                'type'           => $request->account_type,
            ]);
        Alert::success('Success Title', 'Updated Payment Method Successfully');
        return to_route('payment#paymentMethod');
    }

    //update payment method end

    //route to create new admin page start
    public function createAdminPage()
    {
        return view('admin.admin_userAccount.addNewAdmin');
    }
    //route to create new admin page end

    //create new admin acc start
    public function createAdmin(Request $request)
    {
        $this->newAdminValidation($request);

        User::create([
            "name"     => $request->name,
            "email"    => $request->email,
            "phone"    => $request->phone,
            "password" => Hash::make($request->password),
            'role'     => 'admin',
        ]);
        Alert::success('Success Title', 'Create New Admin Account Successfully');
        return back();
    }
    //create new admin acc end

    //validation for new admin start(private)
    private function newAdminValidation($request)
    {
        $request->validate([
            'name'            => 'required',
            'email'           => 'required|email|unique:users,email,',
            'phone'           => 'required|numeric|digits_between:6,15',
            'password'        => 'required|min:6|max:12',
            'confirmPassword' => 'required|min:6|max:12|same:password',
        ]);
    }
    //validation for new admin end(private)

    //admin list page and searchKey start
    public function adminList()
    {
        $admins = User::select('id', 'profile', 'name', 'email',
            'address', 'phone', 'role', 'created_at', 'provider', 'nickname')
            ->whereIn('role', ['admin', 'superadmin'])
        //this query add only when searchKey is entered//
            ->when(request('searchKey'), function ($upperQuery) {
                $upperQuery->whereAny(['name', 'address', 'phone', 'email', 'nickname'],
                    'like', '%' . request('searchKey') . '%');
            })->paginate(5);

        // Pass data to the view
        return view('admin.admin_userAccount.adminList', compact('admins'));
    }
    //admin list page and searchKey end

    //delete admin start
    public function deleteAdmin($id)
    {
        $admin = User::find($id);
        if ($admin) {
            $admin->delete();
        }
        return back();
    }
    //delete admin end

    //delete user start
    public function deleteUser($id)
    {
        $user = User::find($id);
        if ($user) {
            $user->delete();
        }
        return back();
    }
    //delete user end

    //user list page and searchKey start
    public function userList()
    {
        $users = User::select('id', 'profile', 'name', 'email',
            'address', 'phone', 'role', 'created_at', 'provider', 'nickname')
            ->where('role', 'user')
        //this query add only when searchKey is entered start//
            ->when(request('searchKey'), function ($upperQuery) {
                $upperQuery->whereAny(['name', 'address', 'phone', 'email', 'nickname'],
                    'like', '%' . request('searchKey') . '%');
                //this query add only when searchKey is entered end//
            })->paginate(5);

        // Pass data to the view
        return view('admin.admin_userAccount.userList', compact('users'));
    }
    //user list page and searchKey end
}
