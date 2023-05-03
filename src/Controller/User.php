<?php

namespace App\Controller;

use App\Model\User as UserModel;

class User
{
    public function list()
    {
        $user_model = new UserModel();

        $users = $user_model->findAll();

        return json_encode($users, JSON_UNESCAPED_UNICODE);
    }
}