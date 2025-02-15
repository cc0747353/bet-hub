<?php

namespace App\Repositories;

use App\DataTable\UserDataTable;
use App\Models\Address;
use App\Models\City;
use App\Models\Country;
use App\Models\State;
use App\Models\User;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

/**
 * Class UserRepository
 */
class UserRepository extends BaseRepository
{
    public $fieldSearchable = [
        'first_name',
        'last_name',
        'email',
        'contact',
        'status',
        'password',

    ];

    public function getFieldsSearchable(): mixed
    {
        return $this->fieldSearchable;
    }

    public function model(): string
    {
        return User::class;
    }

     public function store($input): User
     {
        $addressInputArray = Arr::only($input,
            ['address_1', 'address_2', 'country_id', 'state', 'city', 'zip']);
        
        try {
            $role = $input['role'];
            DB::beginTransaction();
            $input['email'] = setEmailLowerCase($input['email']);
            $input['status'] = (isset($input['status'])) ? 1 : 0;
            $input['password'] = Hash::make($input['password']);
            $user = User::create($input);
            $user->assignRole($role);
            $address = Address::create([
                'user_id'    => $user->id,
                'country_id' => $addressInputArray['country_id'],
                'address_1'  => $addressInputArray['address_1'],
                'address_2'  => $addressInputArray['address_2'],
                'state'      => $addressInputArray['state'],
                'city'       => $addressInputArray['city'],
                'zip'        => $addressInputArray['zip'],
            ]);
            if (isset($input['profile']) && !empty($input['profile'])) {
                $user->addMedia($input['profile'])->toMediaCollection(User::PROFILE, config('app.media_disc'));
            }

            DB::commit();

            return $user;
        }catch (\Exception $e){
            throw new UnprocessableEntityHttpException($e->getMessage());
        }
    }

    public function update($input, $user): int
    {
        /** @var User $user */
        $addressInputArray = Arr::only($input,
            ['address_1', 'address_2', 'country_id', 'state', 'city', 'zip']);
        
        try {
            DB::beginTransaction();
            if (isset($input['password']) && ! empty($input['password'])) {
                $input['password'] = Hash::make($input['password']);
            }else{
                unset($input['password']);
            }
            $role = $input['role'];
            $input['email'] = setEmailLowerCase($input['email']);
            $input['status'] = (isset($input['status'])) ? 1 : 0;
            $input['type'] = User::MEMBER;
            $user->roles()->sync($role);
            $user->update($input);
            $address = Address::whereUserId($user->id)->first();
            if(!empty($address)) {
                $address->update([
                    'country_id' => $addressInputArray['country_id'],
                    'address_1'  => $addressInputArray['address_1'],
                    'address_2'  => $addressInputArray['address_2'],
                    'state'      => $addressInputArray['state'],
                    'city'       => $addressInputArray['city'],
                    'zip'        => $addressInputArray['zip'],
                ]);
            }else{
                $address = Address::create([
                    'user_id'    => $user->id,
                    'country_id' => $addressInputArray['country_id'],
                    'address_1'  => $addressInputArray['address_1'],
                    'address_2'  => $addressInputArray['address_2'],
                    'state'      => $addressInputArray['state'],
                    'city'       => $addressInputArray['city'],
                    'zip'        => $addressInputArray['zip'],
                ]);
            }
            if (isset($input['profile']) && ! empty($input['profile'])) {
                $user->clearMediaCollection(User::PROFILE);
                $user->media()->delete();
                $user->addMedia($input['profile'])->toMediaCollection(User::PROFILE, config('app.media_disc'));
            }
            DB::commit();

            return true;
        }catch (\Exception $e){
            throw new UnprocessableEntityHttpException($e->getMessage());
        }
    }

}
