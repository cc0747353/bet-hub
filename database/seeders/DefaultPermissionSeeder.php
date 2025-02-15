<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class DefaultPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            [
                'name'         => 'manage_categories',  
                'display_name' => 'Manage Categories',
            ],
            [
                'name'         => 'manage_users',  
                'display_name' => 'Manage Users',
            ],
            [
                'name'         => 'manage_impersonate',
                'display_name' => 'Manage Impersonate',
            ],
            [
                'name'         => 'manage_leagues',
                'display_name' => 'Manage Leagues',
            ],
            [
                'name'         => 'manage_matches',
                'display_name' => 'Manage Matches',
            ],
            [
                'name'         => 'manage_questions',
                'display_name' => 'Manage Questions',
            ],
            [
                'name'         => 'manage_options',
                'display_name' => 'Manage Options',
            ],
            [
                'name'         => 'manage_bets',
                'display_name' => 'Manage Bets',
            ],
            [
                'name'         => 'manage_referrals',
                'display_name' => 'Manage Referrals',
            ],
            [
                'name'         => 'manage_deposit',
                'display_name' => 'Manage Deposit',
            ],
            [
                'name'         => 'manage_withdraw_request',
                'display_name' => 'Manage Withdraw Request',
            ],
            [
                'name'         => 'manage_payment_gateways',
                'display_name' => 'Manage Payment Gateways',
            ],
            [
                'name'         => 'manage_email_template',
                'display_name' => 'Manage Email Template',
            ],
            [
                'name'         => 'manage_sms_template',
                'display_name' => 'Manage SMS Template',
            ],
            [
                'name'         => 'manage_languages',
                'display_name' => 'Manage Languages',
            ],
            [
                'name'         => 'manage_cms',
                'display_name' => 'Manage Cms',
            ],
            [
                'name'         => 'manage_custom_css',
                'display_name' => 'Manage Custom CSS',
            ],
            [
                'name'         => 'manage_seo_tools',
                'display_name' => 'Manage Seo Tools',
            ],
            [
                'name'         => 'manage_roles',
                'display_name' => 'Manage Roles',
            ],
            [
                'name'         => 'manage_news_letter',
                'display_name' => 'Manage News Letter',
            ],
            [
                'name'         => 'manage_settings',
                'display_name' => 'Manage Settings',
            ],
            [
                'name'         => 'manage_system_information',
                'display_name' => 'Manage System Information',
            ],
            [
                'name'         => 'manage_currencies',
                'display_name' => 'Manage Currencies',
            ],
            [
                'name'         => 'manage_user',
                'display_name' => 'Manage User',
            ],
            [
                'name'         => 'manage_dashboard',
                'display_name' => 'Manage Dashboard',
            ],
            [
                'name'         => 'manage_referral',
                'display_name' => 'Manage Referral',
            ],
            [
                'name'         => 'manage_email_manager',
                'display_name' => 'Manage Email Manager',
            ],
            [
                'name'         => 'manage_email_configure',
                'display_name' => 'Manage Email Configure',
            ],
            [
                'name'         => 'manage_sms_global_setting',
                'display_name' => 'Manage SMS Global Setting',
            ],
            [
                'name'         => 'manage_sms_gateway',
                'display_name' => 'Manage SMS Gateway',
            ],
            [
                'name'         => 'manage_blog',
                'display_name' => 'Manage Blog',
            ],
            [
                'name'         => 'manage_faqs',
                'display_name' => 'Manage Faqs',
            ],
            [
                'name'         => 'manage_partners',
                'display_name' => 'Manage Partners',
            ],
            [
                'name'         => 'manage_social_icon',
                'display_name' => 'Manage Social Icon',
            ],
            [
                'name'         => 'manage_edit_profile',
                'display_name' => 'Manage Edit Profile',
            ],
        ];

        foreach ($permissions as $permission) {
            Permission::create($permission);
        }
    }
}
