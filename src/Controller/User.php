<?php

namespace App\Controller;

use App\Model\User as ModelUser;

class User
{
    public function list()
    {
        $user_model = new ModelUser();

        $users = $user_model->findAll();

        return json_encode($users, JSON_UNESCAPED_UNICODE);
    }
}