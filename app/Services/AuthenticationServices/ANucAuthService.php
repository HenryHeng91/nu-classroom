<?php

namespace App\Services\AuthenticationServices;
use App\Models\AppUser;

abstract class ANucAuthService implements INucAuthService
{
    protected  abstract function loginAndGetUserData($request);

    public function authenticate($request)
    {
        $userData = static::loginAndGetUserData($request);
        $user = AppUser::where('accountkit_id', $userData['userId'])->first();

        if ($user == null){
            $newUser = new AppUser();
            $newUser->accountkit_id = $userData['userId'];
            $newUser->first_name = '';
            $newUser->last_name = '';
            $newUser->email = $userData['email'];
            $newUser->phone = $userData['phone'];
            $newUser->gender = 'male';
            $newUser->access_token = $userData['userAccessToken'];
            $newUser->status = 1;
            $newUser->guid = uniqid();
            $newUser->save();
            $user = $newUser;
            $request->merge(['NU_CLASSROOM_USER' => ['userId' => $user->guid, 'status' => 'new' ]]);
        } else {
            $user->access_token = $userData['userAccessToken'];
            $user->save();
            $request->merge(['NU_CLASSROOM_USER' => ['userId' => $user->guid, 'status' => 'old' ]]);
        }

        return $request;
    }

}
