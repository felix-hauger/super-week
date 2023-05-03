<?php

namespace App\Controller;

use App\Entity\User;
use App\Model\User as ModelUser;
use Exception;

class Auth
{
    public function register()
    {
        $input = [
            'email' => filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL),
            'password' => filter_input(INPUT_POST, 'password', FILTER_SANITIZE_FULL_SPECIAL_CHARS),
            'confirm' => filter_input(INPUT_POST, 'confirm', FILTER_SANITIZE_FULL_SPECIAL_CHARS),
            'first_name' => filter_input(INPUT_POST, 'first_name', FILTER_SANITIZE_FULL_SPECIAL_CHARS),
            'last_name' => filter_input(INPUT_POST, 'last_name', FILTER_SANITIZE_FULL_SPECIAL_CHARS)
        ];

        if ($input['password'] === $input['confirm']) {
            foreach ($input as $key => $value) {
                if (!$value) {
                    return str_replace('_', ' ', ucwords($key)) . ' input invalid.';
                }
            }

            $user = new User();

            $user_model = new ModelUser();

            $user
                ->setEmail($input['email'])
                ->setPassword($input['password'])
                ->setFirstName($input['first_name'])
                ->setLastName($input['last_name']);

            $user_model->create($user);
        } else {
            return 'The password and its confirmation must match.';
        }
    }
}