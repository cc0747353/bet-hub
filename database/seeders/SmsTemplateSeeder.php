<?php

namespace Database\Seeders;

use App\Models\EmailTemplate;
use App\Models\SmsTemplate;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SmsTemplateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $inputs = [
            [
                'name'      => 'Password Reset',
                'message'   => 'Your account recovery code is: {{code}}',
                'status'    => 1,
                'variables' => '#code#',
            ],
            [
                'name'    => 'Password Reset Confirmation',
                'message' => 'Your password has been changed successfully',
                'status'  => 1,
                'variables' => '#code#',
            ],
            [
                'name'      => 'Email Verification',
                'message'   => 'Your email verification code is: {{code}}',
                'status'    => 1,
                'variables' => '#code#',
            ],
            [
                'name'      => 'SMS Verification',
                'message'   => 'Your phone verification code is: {{code}}',
                'status'    => 1,
                'variables' => '#code#',
            ],
            [
                'name'      => 'Google Two Factor - Enable',
                'message'   => 'Your verification code is: {{code}}',
                'status'    => 1,
                'variables' => '#code#',
            ],
            [
                'name'    => 'Google Two Factor Disable',
                'message' => 'Google two factor verification is disabled',
                'status'  => 1,
                'variables' => '#code#',
            ],
            [
                'name'      => 'Support Ticket Reply',
                'message'   => '<pre>{{subject}}{{reply}}Click here to reply:  {{link}}</pre>',
                'status'    => 1,
                'variables' => '#subject#, #reply#, #link#',
            ],
            [
                'name'      => 'Manual Deposit - User Requested',
                'message'   => '{{amount}} Deposit requested by {{amount}}. Charge: {{charge}} . Trx: {{trx}}',
                'status'    => 1,
                'variables' => '#amount#, #charge#, #trx#',
            ],
            [
                'name'      => 'Manual Deposit - Admin Approved',
                'message'   => 'Admin Approve Your {{amount}} {{gateway_currency}} payment request by {{gateway_name}} transaction : {{transaction}}',
                'status'    => 1,
                'variables' => '#amount#, #gateway_currency#, #gateway_name#, #transaction#',
            ],
            [
                'name'      => 'Manual Deposit - Admin Rejected',
                'message'   => 'Admin Rejected Your {{amount}} {{gateway_currency}} payment request by {{gateway_name}}{{rejection_message}}',
                'status'    => 1,
                'variables' => '#amount#, #gateway_currency#, #gateway_name#, #rejection_message#',
            ],
            [
                'name'      => 'Withdraw  - User Requested',
                'message'   => '{{amount}} {{currency}} withdraw requested by {{method_name}}. You will get {{method_amount}} {{method_currency}} in {{delay}}. Trx: {{trx}}',
                'status'    => 1,
                'variables' => '#amount#, #currency#, #method_name#, #method_amount#, #method_currency#, #delay#, #trx#',
            ],
            [
                'name'      => 'Withdraw - Admin Rejected',
                'message'   => 'Admin Rejected Your {{amount}} {{currency}} withdraw request. Your Main Balance {{main_balance}}  {{method}} , Transaction {{transaction}}',
                'status'    => 1,
                'variables' => '#amount#, #currency#, #main_balance#, #method#, #transaction#',
            ],
            [
                'name'      => 'Withdraw - Admin  Approved',
                'message'   => 'Admin Approve Your {{amount}} {{currency}} withdraw request by {{method}}. Transaction {{transaction}}',
                'status'    => 1,
                'variables' => '#amount#, #currency#, #method#, #transaction#',
            ],
            [
                'name'      => 'Bet Placed Successfully',
                'message'   => '<pre>{{invest_amount}} {{currency}} has been subtracted from your account  for placing bet for {{option}}.

                    Transaction Number : {{trx}}
                    
                    Betting Details : 
                    
                    Match : {{match}}
                    Question : {{question}}
                    Bet For : {{option}}
                    Invest : {{invest_amount}} {{currency}}
                    Return : {{return_amount}} {{currency}} [If you win]
                    
                    Your Current Balance is : {{post_balance}}  {{currency}}</pre>',
                'status'    => 1,
                'variables' => '#invest_amount#, #currency#, #option#, trx, #match#, #question#, #invest_amount#, #return_amount#, #post_balance#',
            ],
            [
                'name'      => 'Referral Commission',
                'message'   => '<pre>{{invest_amount}} {{currency}} has been subtracted from your account  for placing bet for {{option}}.

                   Transaction Number : {{trx}}
                   
                   Betting Details : 
                   
                   Match : {{match}}
                   Question : {{question}}
                   Bet For : {{option}}
                   Invest : {{invest_amount}} {{currency}}
                   Return : {{return_amount}} {{currency}} [If you win]
                   
                   Your Current Balance is : {{post_balance}}  {{currency}}</pre>',
                'status'    => 1,
                'variables' => '#invest_amount#, #currency#, #option#, trx, #match#, #question#, #invest_amount#, #return_amount#,#post_balance#',
            ],
        ];

        foreach ($inputs as $input) {
            SmsTemplate::create($input);
        }
    }
}
