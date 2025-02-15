<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\User;
use Carbon\Carbon;
//use Couchbase\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class DefaultAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $superAdmin = [
            'first_name'        => 'Admin',
            'last_name'         => 'Bet',
            'email'             => 'admin@infybetting.com',
            'email_verified_at' => Carbon::now(),
            'password'          => Hash::make('123456'),
        ];
        $user =  User::create($superAdmin);
        $user->assignRole('superAdmin');
        $member =  [
            'first_name'        => 'user',
            'last_name'         => 'Bet',
            'email'             => 'user@infybetting.com',
            'user_name'         => 'user1betting',
            'email_verified_at' => Carbon::now(),
            'password'          => Hash::make('123456'),
            ];
        $user =  User::create($member);
        $user->assignRole('member');
    }
}
