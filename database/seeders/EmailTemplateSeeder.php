<?php

namespace Database\Seeders;

use App\Models\EmailTemplate;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EmailTemplateSeeder extends Seeder
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
                'name'    => 'Password Reset',
                'subject' => 'Password Reset',
                'message' => '<h2>Hello</h2>
                                <p>Please click the button below to verify your email address.</p>
                                 #link# 
                                 <p>If you did not create an account, no further action is required.</p>
                                 ',
                'status'  => 1,
                'variables' => '#link#'
            ],
            [
                'name'    => 'Password Reset Confirmation',
                'subject' => 'You have Reset your password',
                'message' => '<p>You have successfully reset your password.</p><p>You changed from&nbsp;IP:&nbsp;<strong>{{ip}}</strong>&nbsp;using&nbsp;<strong>{{browser}}</strong>&nbsp;on&nbsp;<strong>{{operating_system}}&nbsp;</strong>&nbsp;on&nbsp;<strong>{{time}}</strong></p><p><br></p><h2><strong style="color: rgb(230, 0, 0);">If you did not changed that, Please contact with us as soon as possible.</strong></h2>',
                'status'  => 1,
                'variables' => '#name#,#link#'
            ],
            [
                'name'    => 'Email Verification',
                'subject' => 'Please verify your email address',
                'message' => '<h2>Hello</h2>
                                <p>Please click the button below to verify your email address.</p>
                                                            #link#
                                <p>If you did not create an account, no further action is required.</p>
                                 ',
                'status'  => 1,
                'variables' => '#link#'
            ],
            [
                'name'    => 'SMS Verification',
                'subject' => 'Please verify your phone',
                'message' => '<h2>Your phone verification code is: {{code}}</h2>',
                'status'  => 0,
                'variables' => '#name#,#link#'
            ],
            [
                'name'    => 'Google Two Factor - Enable',
                'subject' => 'Google Two Factor Authentication is now Enabled for Your Account',
                'message' => '<p>You just enabled Google Two Factor Authentication for Your Account.</p><p><br></p><h2>Enabled at&nbsp;<strong>{{time}}&nbsp;</strong>From IP:&nbsp;<strong>{{ip}}</strong>&nbsp;using&nbsp;<strong>{{browser}}</strong>&nbsp;on&nbsp;<strong>{{operating_system}}&nbsp;</strong>.</h2>',
                'status'  => 1,
                'variables' => '#name#,#link#'
            ],
            [
                'name'    => 'Google Two Factor Disable',
                'subject' => 'Google Two Factor Authentication is now Disabled for Your Account',
                'message' => '<p>You just Disabled Google Two Factor Authentication for Your Account.</p><p><br></p><h2>Disabled at&nbsp;<strong>{{time}}&nbsp;</strong>From IP:&nbsp;<strong>{{ip}}</strong>&nbsp;using&nbsp;<strong>{{browser}}</strong>&nbsp;on&nbsp;<strong>{{operating_system}}&nbsp;</strong>.</h2>',
                'status'  => 1,
                'variables' => '#name#,#link#'
            ],
            [
                'name'    => 'Support Ticket Reply',
                'subject' => 'Reply Support Ticket',
                'message' => '<p><strong>A member from our support team has replied to the following ticket:</strong></p><p><br></p><p><strong>[Ticket#{{ticket_id}}] {{ticket_subject}}</strong></p><p><br></p><p><strong>Click here to reply:&nbsp;{{link}}</strong></p><p>----------------------------------------------</p><p>Here is the reply :</p><h2>{{reply}}</h2>',
                'status'  => 1,
                'variables' => '#name#,#link#'
            ],
            [
                'name'    => 'Deposit',
                'subject' => 'User Add Deposit',
                'message' => '<p><br></p><p><strong>Deposit Details :</strong></p><p></p><p><strong>Name : </strong>#name#</p><p><strong>Amount : </strong>#currency# #amount#</p><p><strong>Charge:</strong>&nbsp;#currency# #charge#</p><p></p><p><strong>Pay via : </strong>#method_name#</p><p></p><p><strong>Transaction Number : </strong>#trn#</p>#link#',
                'status'  => 1,
                'variables' => '#link#,#amount#,#currency#,#method_name#,#name#,#charge#,#trn#'
            ],
            [
                'name'    => 'Manual Deposit - Admin Approved',
                'subject' => 'Your Deposit is Approved',
                'message' => '<p>Your deposit request of&nbsp;<strong>{{amount}} {{currency}}</strong>&nbsp;is via&nbsp;&nbsp;<strong>{{method_name}}&nbsp;</strong>is Approved .</p><p><br></p><p><strong>Details of your Deposit :</strong></p><p><br></p><p>Amount : {{amount}} {{currency}}</p><p>Charge:&nbsp;{{charge}} {{currency}}</p><p><br></p><p>Conversion Rate : 1 {{currency}} = {{rate}} {{method_currency}}</p><p>Payable : {{method_amount}} {{method_currency}}</p><p>Paid via :&nbsp;{{method_name}}</p><p><br></p><p>Transaction Number : {{trx}}</p><p><br></p><h2>Your current Balance is&nbsp;<strong>{{post_balance}} {{currency}}</strong></h2>',
                'status'  => 1,
                'variables' => '#name#,#link#'
            ],
            [
                'name'    => 'Manual Deposit - Admin Rejected',
                'subject' => 'Your Deposit Request is Rejected',
                'message' => '<p>Your deposit request of&nbsp;<strong>{{amount}} {{currency}}</strong>&nbsp;is via&nbsp;&nbsp;<strong>{{method_name}} has been rejected</strong>.</p><p><br></p><p>Transaction Number was : {{trx}}</p><p><br></p><p>if you have any query, feel free to contact us.</p><p><br></p><p><br></p><p><br></p><h2>{{rejection_message}}</h2>',
                'status'  => 1,
                'variables' => '#name#,#link#'
            ],
            [
                'name'    => 'Withdraw Request - User',
                'subject' => 'Withdraw Request User',
                'message' => '<p><br><p><strong>Withdraw Request Details :</strong></p><p><strong>Name : </strong>#name#</p><p><strong>Amount : </strong>#currency# #amount#</p><p><strong>Via :&nbsp;</strong>#method_name#</p></p><p></p><p><strong>#name#</strong> current Balance is&nbsp;<strong>#currency# #post_balance#</strong></p>#link#',
                'status'  => 1,
                'variables' => '#link#,#name#,#currency#,#amount#,#method_name#,#post_balance#'
            ],
            [
                'name'    => 'Withdraw Request Rejected - Admin',
                'subject' => 'Your Withdraw Request Rejected',
                'message' => '<p><br><p><p>Your withdraw request has been rejected.</p><p><strong>Withdraw Request Details :</strong></p><p>Amount : #currency# #amount#</p><p>Via :&nbsp;#method_name#</p>',
                'status'  => 1,
                'variables' => '#currency#,#amount#,#method_name#'
            ],
            [
                'name'    => 'Withdraw Request Approved - Admin',
                'subject' => 'Your Withdraw Request Approved',
                'message' => '<p><br><p><p>Your withdraw request has been approved.</p><p><strong>Withdraw Request Details :</strong></p><p>Amount : #currency# #amount#</p><p>Via :&nbsp;#method_name#</p>',
                'status'  => 1,
                'variables' => '#currency#,#amount#,#method_name#'
            ],
            [
                'name'    => 'Bet Placed',
                'subject' => 'Your Bet Is Placed',
                'message' => '<p>Your bet placed successfully.</p><p><strong>Betting Details :&nbsp;</strong></p><p><strong>Match :&nbsp;</strong>#match#</p><p><strong>Question :&nbsp;</strong>#question#</p><p><strong>Bet For :&nbsp;</strong>#option#</p><p><strong>Bet Amount :&nbsp;</strong>#currency# #amount#</p><p><strong>Return Amount :&nbsp;</strong>#currency# #return_amount#&nbsp;[If you win]</p><p><strong>Your Current Balance is :&nbsp;</strong>#currency# #post_balance#&nbsp;</p>#link#',
                'status'  => 1,
                'variables' => '#currency#,#amount#,#option#,#match#,#question#,#return_amount#,#post_balance#,#link#'
            ],
            [
                'name'    => 'Bet Win',
                'subject' => 'You Are Win The Bet',
                'message' => '<p><strong>Congratulations,&nbsp;</strong>you are win the bet&nbsp;.</p><p><strong>Betting Details :&nbsp;</strong></p><p><strong>Match :&nbsp;</strong>#match#</p><p><strong>Question :&nbsp;</strong>#question#</p><p><strong>Bet For :&nbsp;</strong>#option#</p><p><strong>Bet Amount :&nbsp;</strong>#currency# #invest_amount#</p><p><strong>You win :&nbsp;</strong>#currency# #winner_amount#&nbsp;</p>#link#',
                'status'  => 1,
                'variables' => '#currency#,#winner_amount#,#match#,#question#,#option#,#invest_amount#,#name#,#link#'
            ],
            [
                'name'    => 'Bet Lose',
                'subject' => 'You Are Lose The Bet',
                'message' => '<p>You are lose the bet&nbsp;.</p><p><strong>Betting Details :&nbsp;</strong></p><p><strong>Match :&nbsp;</strong>#match#</p><p><strong>Question :&nbsp;</strong>#question#</p><p><strong>Bet For :&nbsp;</strong>#option#</p><p><strong>Bet Amount :&nbsp;</strong>#currency# #lose_amount#</p>#link#',
                'status'  => 1,
                'variables' => '#match#,#question#,#option#,#currency#,#lose_amount#,#link#'
            ],
            [
                'name'    => 'Bet Refund',
                'subject' => 'Your Bet refunded',
                'message' => '<p>Your bet amount refunded.</p><p><strong>Bet Details :&nbsp;</strong></p><p><strong>Match :&nbsp;</strong>#match#</p><p><strong>Question :&nbsp;</strong>#question#</p><p><strong>Bet For :&nbsp;</strong>#option#</p><p><strong>Bet Amount :&nbsp;</strong>#currency# #refund_amount#</p>#link#',
                'status'  => 1,
                'variables' => '#match#,#question#,#option#,#currency#,#refund_amount#,#link#'
            ],
            [
                'name'    => 'Referral Commission',
                'subject' => 'You Got Referral Commission',
                'message' => '<p><strong>Congratulations,&nbsp;</strong>you got #currency# #amount# as referral <strong>#type#</strong>.</p><p><br></p><p><strong>Amount :&nbsp;</strong>#currency# #amount#</p><p><strong>Referral To :&nbsp;</strong>#referral_to#</p><p><strong>Transaction Number :&nbsp;</strong>#trx#</p><p><strong>Commission Type :&nbsp;</strong>#type#</p><strong>Level :&nbsp;</strong>#level#</p>#link#',
                'status'  => 1,
                'variables' => '#currency#,#amount#,#name#,#referral_to#,#trx#,#type#,#level#,#link#'
            ],
        ];

        foreach ($inputs as $input) {
            EmailTemplate::create($input);
        }
    }
}
