<?php

namespace App\Http\Controllers;

use App\Models\SmsGateways;
use App\Repositories\SmsGatewaysRepository;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Laracasts\Flash\Flash;
use Twilio\Exceptions\ConfigurationException;
use Twilio\Exceptions\TwilioException;
use Twilio\Rest\Client;


class SmsGatewaysController extends Controller
{
    /**
     * @param SmsGatewaysRepository $gatewaysRepository
     */
    public function __construct(SmsGatewaysRepository $gatewaysRepository)
    {
        $this->gatewaysRepo = $gatewaysRepository;
    }

    /**
     *
     *
     * @return Application|Factory|View
     */
    public function index()
    {
        $smsSendMethod = SmsGateways::SEND_SMS_METHOD;
        $smsGatewaysData = SmsGateways::pluck('value', 'key')->toArray();

        return view('sms_templates.sms_gateways.index', compact('smsSendMethod', 'smsGatewaysData'));
    }

    /**
     * @param Request $request
     *
     *
     * @return Application|RedirectResponse|Redirector
     */
    public function update(Request $request)
    {
        $id = 1;
        $this->gatewaysRepo->update($request->all(), $id);

        Flash::success(__('messages.flash.SMS_gateways_updated'));

        return redirect(route('sms.gateways.index'));
    }

    public function sendSMS(Request $request)
    {
        $sms = SmsGateways::pluck('value', 'key');
        $mobile_number = '+'.$request['region_code'].$request['mobile_number'];
        if (empty($sms['nexmo_api_key']) || empty($sms['nexmo_api_secret'])){
            Flash::error('SMS Credentials are required for Test SMS.');

            return redirect(route('sms.gateways.index'));
        }
        
        $basic = new \Vonage\Client\Credentials\Basic($sms['nexmo_api_key'], $sms['nexmo_api_secret']);
        $client = new \Vonage\Client($basic);

        $response = $client->sms()->send(
            new \Vonage\SMS\Message\SMS($mobile_number, 'InfyOm', 'Test sms')
        );

        $message = $response->current();

        if ($message->getStatus() == 0) {
            Flash::success(__('messages.flash.test_sms_send'));

            return redirect(route('sms.gateways.index'));
        }

        echo "The message failed with status: ".$message->getStatus()."\n";
        return redirect(route('sms.gateways.index'));
    }

    /**
     * @throws ConfigurationException
     * @throws TwilioException
     */
    public function sendSMSTwilio(Request $request)
    {
        $sms = SmsGateways::pluck('value', 'key');
        $mobile_number = '+'.$request['region_code'].$request['mobile_number'];
        
        $sid = $sms['account_sid'];
        $token = $sms['auth_token'];
        $fromNumber = '+'.$sms['from_number'];
        $twilio = new Client($sid, $token);
        $message = $twilio->messages->create($mobile_number,
                array(
                    "body" => "Your message",
                    "from" => $fromNumber,
                )
            );
        
        if (!empty($message->sid)) {
            Flash::success(__('messages.flash.test_sms_send'));
            return redirect(route('sms.gateways.index'));
        }
        return redirect(route('sms.gateways.index'));
    }
}
