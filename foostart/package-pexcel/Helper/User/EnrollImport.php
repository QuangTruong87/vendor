<?php namespace Foostart\Pexcel\Helper\User;

use Foostart\Acl\Authentication\Repository\UserRepositorySearchFilter;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Str;
use Foostart\Courses\Models\ClassesUsers;

class EnrollImport
{
    public $item;

    public function __construct($item)
    {
        $this->item = $item;
    }
    /**
     * Import user from external file
     * @param $users
     */
    public function enrollUsers($users) {
        $users = $this->updateUserInfo($users);

        $obj_class_user = new ClassesUsers();

        //Clear course with course_id
        $_params = [
            'course_id' => $this->item->course_id
        ];
        $obj_class_user->deleteItems($_params, 'delete-forever');

        for($i = 0; $i < count($users); $i++) {

            //Existing user
            if (!empty($users[$i]['id'])) {
                $user_data = [
                    "course_id" => $this->item->course_id,
                    "user_id" => $users[$i]['id'],
                ];

                try {
                    $item = $obj_class_user->selectItem($user_data);
                    if (!empty($item)) {
                        $item->deleteItem(['id' => $item->class_user_id], 'delete-forever');
                    }

                    $obj_class_user->insertItem($user_data);


                } catch (\Throwable $e) {
                    dd($e);
                }
            }

        }
    }

    public function updateUserInfo($users) {
        $user_repository = App::make('user_repository');
        $profile_repository = App::make('profile_repository');

        $obj_user = new UserRepositorySearchFilter(0);

        for ($i = 0; $i < count($users); $i++) {
            $params = [
                'user_name' => Str::lower($users[$i]['user_name'])
            ];
            $user_info = $obj_user->all($params)->first();

            if (!empty($user_info)) {
                $users[$i]['id'] = $user_info->id;
            }
        }

        return $users;

    }
}
