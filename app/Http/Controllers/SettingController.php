<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateSettingRequest;
use App\Models\Currency;
use App\Models\PaymentGateway;
use App\Models\Setting;
use App\Repositories\SettingRepository;
use Illuminate\Http\RedirectResponse;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use Laracasts\Flash\Flash;

class SettingController extends AppBaseController
{

    /**
     * @var SettingRepository
     */
    private SettingRepository $settingRepository;

    /**
     * @param SettingRepository $settingRepository
     */
    public function __construct(SettingRepository $settingRepository)
    {
        $this->settingRepository = $settingRepository;
    }


    public function index(): Application|Factory|View
    {
        $setting = Setting::all()->pluck('value', 'key');
        $paymentGateways = PaymentGateway::PAYMENT_METHOD;
        $selectedPaymentGateways = PaymentGateway::pluck('name')->toArray();
        $currencies = Currency::toBase()->pluck('currency_name', 'id');

        return view('settings.index', compact('setting', 'paymentGateways', 'selectedPaymentGateways', 'currencies'));
    }

    public function update(UpdateSettingRequest $request): Application|RedirectResponse|Redirector
    {
        $input = $request->all();
        if ($request->show_captcha == null) {
            $input['show_captcha'] = '0';
        } else {
            $this->validate($request, [
                'site_key'   => 'required',
                'secret_key' => 'required',
            ]);
        }
        $id = Auth::id();
        $this->settingRepository->update($input, $id);
        Flash::success(__('messages.flash.setting_updated'));

        return redirect(route('settings.index'));
    }

    public function clearCache(): RedirectResponse
    {
        Artisan::call('cache:clear');
        Flash::success(__('messages.flash.application_cache_cleared'));

        return redirect()->back();
    }

    /**
     *
     *
     * @return Application|Factory|View
     */
    public function paymentMethodIndex()
    {
        $paymentGateways = PaymentGateway::PAYMENT_METHOD;
        $selectedPaymentGateways = PaymentGateway::pluck('payment_gateway')->toArray();

        return view('payment_method.index', compact('paymentGateways', 'selectedPaymentGateways'));
    }

    /**
     * @param Request $request
     *
     *
     * @return Application|RedirectResponse|Redirector
     */
    public function paymentMethodUpdate(Request $request)
    {
        $paymentGateways = $request->payment_gateway;
        if (!empty($paymentGateways)) {
            PaymentGateway::query()->delete();
        }
        if (isset($paymentGateways)) {
            foreach ($paymentGateways as $paymentGateway) {
                PaymentGateway::updateOrCreate(['payment_gateway_id' => $paymentGateway],
                    [
                        'payment_gateway' => PaymentGateway::PAYMENT_METHOD[$paymentGateway],
                    ]);
            }
        }
        Flash::success(__('messages.flash.payment_method_updated'));

        return redirect(route('payment-method.index'));
    }
}
