<?php namespace Foostart\Pexcel\Helper\User;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Str;

class UserImport
{
    /**
     * Import user from external file
     * @param $users
     */
    public function importUsers($users) {
        $user_repository = App::make('user_repository');
        $profile_repository = App::make('profile_repository');

        for($i = 0; $i < count($users); $i++) {

            $user_data = [
                "email" => Str::lower($users[$i]['email']),
                "user_name" => Str::lower($users[$i]['user_name']),
                "password" => Str::lower($users[$i]['user_name']),
                "activated" => 1
            ];

            try {
                $user = $user_repository->create($user_data);
                $user->first_name = $users[$i]['first_name'];
                $user->last_name = $users[$i]['last_name'];
                $profile_repository->attachEmptyProfile($user);
            } catch (\Throwable $e) {

            }
        }
    }
}
