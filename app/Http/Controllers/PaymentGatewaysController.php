<?php

namespace App\Http\Controllers;

use App\Models\PaymentGateway;
use App\Models\PaymentGatewaysFields;
use App\Repositories\PaymentGatewaysRepository;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Laracasts\Flash\Flash;

class PaymentGatewaysController extends AppBaseController
{

    /**
     * @param PaymentGatewaysRepository $paymentGatewaysRepository
     */
    public function __construct(PaymentGatewaysRepository $paymentGatewaysRepository)
    {
        $this->paymentGatewaysRepo = $paymentGatewaysRepository;
    }

    /**
     *
     *
     * @return Application|Factory|View
     */
    public function index()
    {
        return view('payment_gateways.index');
    }

    /**
     * @param Request $request
     *
     *
     * @return Application|RedirectResponse|Redirector
     */
    public function store(Request $request)
    {
        $this->paymentGatewaysRepo->store($request->all());
        Flash::success(__('messages.flash.payment_gateways_updated'));

        return redirect(route('payment-gateways.index'));
    }

    /**
     * @param $id
     *
     *
     * @return Application|Factory|View
     */
    public function edit($id)
    {
        $gateways = PaymentGatewaysFields::where('payment_id', $id)->where('type',
            PaymentGatewaysFields::CREDENTIALS)->get()->toArray();
        $range_data = PaymentGatewaysFields::where('payment_id', $id)->where('type',
            PaymentGatewaysFields::RANGE)->get()->toArray();
        $charge_data = PaymentGatewaysFields::where('payment_id', $id)->where('type',
            PaymentGatewaysFields::CHARGE)->get()->toArray();

        return view('payment_gateways.edit', compact('gateways', 'range_data', 'charge_data'));
    }

    public function changeStatus($id): JsonResponse
    {
        $gateways = PaymentGateway::findOrFail($id);
        
        $gateways->update(['status' => $gateways->status == 0 ? 1 : 0]);

        return $this->sendResponse($gateways, __('messages.flash.payment_gateways_status'));
    }
}
