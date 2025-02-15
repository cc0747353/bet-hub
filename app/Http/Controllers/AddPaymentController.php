<?php

namespace App\Http\Controllers;

use App\Models\DepositTransaction;
use App\Models\PaymentGateway;
use App\Models\PaymentGatewaysFields;
use App\Models\Setting;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;

class AddPaymentController extends Controller
{
    /**
     *
     *
     * @return Application|Factory|View
     */
    public function index()
    {
        $allPaymentStatus = PaymentGateway::pluck('status', 'name')->toArray();

        return view('deposit.index', compact('allPaymentStatus'));
    }

    /**
     *
     *
     * @return Application|Factory|View
     */
    public function create()
    {
        $allPaymentStatus = PaymentGateway::get()->keyBy('name');

        return view('deposit.create', compact('allPaymentStatus'));
    }

    /**
     * @param $id
     *
     *
     * @return Application|Factory|View
     */
    public function show($id)
    {
        $allPaymentStatus = PaymentGateway::whereId($id)->first();
//        $minAndMax = Setting::all()->pluck('value' ,'key');
        $range_data = PaymentGatewaysFields::where('payment_id', $id)->where('type',
            PaymentGatewaysFields::RANGE)->get()->toArray();
        $minAndMax = PaymentGatewaysFields::where('payment_id', $id)->where('type',
            PaymentGatewaysFields::CHARGE)->get()->toArray();

        return view('deposit.payment-amount', compact('minAndMax', 'allPaymentStatus', 'range_data'));

    }

    /**
     *
     *
     * @return Application|Factory|View
     */
    public function getAllPaymentStatus()
    {
        return view('transaction.index');
    }

    /**
     *
     *
     * @return Application|Factory|View
     */
    public function getDepositAmount()
    {
        $minAndMax = Setting::pluck('value', 'key')->toArray();

        return view('deposit.payment-amount', compact('minAndMax'));
    }

    public function depositDetails($id)
    {
        $transaction = DepositTransaction::find($id);

        return view('transaction.deposit_transaction_details', compact('transaction'));
    }
}
