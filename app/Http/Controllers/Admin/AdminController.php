<?php
namespace App\Http\Controllers\Admin;

use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use RealRashid\SweetAlert\Facades\Alert;

class AdminController extends Controller
{
    //admin dashboard
    public function dashboard()
    {
        return view('admin.dashboard.mainDashboard');
    }
    public function createPaymentMethodPage()
    {
        //payment lists data conpact start
        $payments = Payment::all();
        return view('admin.payment.paymentMehod', compact('payments'));
        //payment lists data conpact end
    }

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

    //input validationCheck for payment method start
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

    //input validationCheck for payment method end

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

    public function createAdminPage()
    {
        dd('the is create Admin Page');
    }

    public function adminList()
    {
        dd('the is admin list');
    }

    public function userList()
    {
        dd('the is user list');
    }
}
