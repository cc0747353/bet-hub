<?php

namespace App\Http\Controllers;

use App\Mail\ManuallyPaymentRequest;
use App\Models\DepositTransaction;
use App\Models\EmailTemplate;
use App\Models\PaymentGateway;
use App\Models\PaymentGatewaysFields;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class ManuallyPaymentController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'totalAmount' => 'required',
            'notes'       => 'required',
            'attach' => 'required|mimes:jpeg,png,jpg,mp4,mov,ogg,doc,docx,eot,xlsx,xlsb,xls,css,csv,wmv,avi',
        ]);

        $input = $request->all();
        $paymentAmount = $request['totalAmount'];
        $fixTax = PaymentGatewaysFields::where('key', 'manually_fixed_charge')->where('type',
            PaymentGatewaysFields::CHARGE)->value('value');
        $percentTax = PaymentGatewaysFields::where('key', 'manually_percent_charge')->where('type',
            PaymentGatewaysFields::CHARGE)->value('value');

        if (!empty($fixTax)) {
            $depositAmount = $paymentAmount - $fixTax;
        } else {
            $totalTax = 100 + $percentTax;
            $taxAmount = $paymentAmount * $percentTax / $totalTax;
            $depositAmount = $paymentAmount - $taxAmount;
        }

        $transaction = DepositTransaction::create([
            'transaction_id' => Str::random(30),
            'type'           => PaymentGateway::MANUALLY,
            'amount'         => $paymentAmount,
            'deposit_amount' => $depositAmount,
            'tax'            => !empty($fixTax) ? $fixTax : $percentTax,
            'user_id'        => getLogInUserId(),
            'currency_id'    => getCurrencyId(),
            'status'         => DepositTransaction::PENDING,
            'notes'          => $input['notes'],
        ]);

        if (isset($input['attach']) && !empty('attach')) {
            $transaction->addMedia($input['attach'])->toMediaCollection(DepositTransaction::ATTACHMENT,
                config('app.media_disc'));
        }

        $input['email'] = EmailTemplate::where('name' ,'Deposit')->first();
        $input['name'] = getLogInUser()->full_name;
        $input['transaction_number'] = $transaction['transaction_id'];
        $input['charge'] = $taxAmount;
        $input['currency'] = getCurrencyIcon();
        
        Mail::to(getAdminEmail())
            ->send(new ManuallyPaymentRequest('emails.manually_payment_request_mail',
                __($input['email']->subject),
                $input));
        
        return response()->json(['success' => true, 'message' => __('messages.flash.app_payment_successful')]);
    }
}
