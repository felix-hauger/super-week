<?php

namespace App\Controller;

use App\Entity\User;
use App\Model\User as ModelUser;
use Exception;

class Auth
{
    /**
     * Register user in database
     * @return bool If the user is successfully registered or not
     */
    public function register()
    {
        $input = [
            'email' => filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL),
            'password' => filter_input(INPUT_POST, 'password', FILTER_SANITIZE_FULL_SPECIAL_CHARS),
            'confirm' => filter_input(INPUT_POST, 'confirm', FILTER_SANITIZE_FULL_SPECIAL_CHARS),
            'first_name' => filter_input(INPUT_POST, 'firstname', FILTER_SANITIZE_FULL_SPECIAL_CHARS),
            'last_name' => filter_input(INPUT_POST, 'lastname', FILTER_SANITIZE_FULL_SPECIAL_CHARS)
        ];

        if ($input['password'] === $input['confirm']) {
            foreach ($input as $key => $value) {
                if (!$value) {
                    throw new Exception(str_replace('_', ' ', ucwords($key)) . ' input invalid.');
                }
            }

            $user_model = new ModelUser();

            if ($user_model->isFieldInDb('email', $input['email'])) {
                throw new Exception('The email already exists.');
            }

            $user = new User();

            $user
                ->setEmail($input['email'])
                ->setPassword(password_hash($input['password'], PASSWORD_DEFAULT))
                ->setFirstName($input['first_name'])
                ->setLastName($input['last_name']);

            return $user_model->create($user);
        } else {
            throw new Exception('The password and its confirmation must match.');
        }
    }

    /**
     * To log user in session
     * @return User Entity filled with database user infos
     */
    public function login(): User
    {
        $input = [
            'email' => filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL),
            'password' => filter_input(INPUT_POST, 'password', FILTER_SANITIZE_FULL_SPECIAL_CHARS)
        ];

        foreach ($input as $key => $value) {
            if (!$value) {
                throw new Exception(ucwords($key) . ' input invalid.');
            }
        }

        $user_model = new ModelUser();

        $db_user = $user_model->findBy(['email' => $input['email']]);

        if (password_verify($input['password'], $db_user['password'])) {
            $user = new User();

            $user
                ->setId($db_user['id'])
                ->setEmail($db_user['email'])
                ->setFirstName($db_user['first_name'])
                ->setLastName($db_user['last_name']);

            return $user;
        }

        throw new Exception('Incorrect credentials.');
    }
}