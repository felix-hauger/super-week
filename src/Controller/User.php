<?php

namespace App\Controller;

use App\Entity\User as EntityUser;
use App\Model\User as ModelUser;

class User
{
    /**
     * @return string Infos of all users json formatted
     */
    public function list(): string
    {
        $user_model = new ModelUser();

        $users = $user_model->findAll();

        return json_encode($users, JSON_UNESCAPED_UNICODE);
    }

    /**
     * @param int $id The user id
     * @return string Infos of one user json formatted
     */
    public function getInfos(int $id)
    {
        $user_model = new ModelUser();

        $user = $user_model->find($id);

        return json_encode($user, JSON_UNESCAPED_UNICODE);
    }

    /**
     * Fill the user table with fake infos for exemple
     * Email is generated with first_name & last_name
     * Password is generated with firstname
     */
    public function fill(): void
    {
        $user_model = new ModelUser();

        $user = new EntityUser();        

        $faker = \Faker\Factory::create('fr_FR');

        for ($i = 0; $i < 30; $i++) {
    
            $first_name = $faker->firstName();
            $last_name = $faker->lastName();
            // Convert UTF-8 characters to ASCII to create email without accents
            $email = strtolower(iconv('UTF-8', 'ASCII//TRANSLIT', $first_name . '.' . $last_name)) . '@' . $faker->freeEmailDomain();
            $password = password_hash($first_name, PASSWORD_DEFAULT);

            $user
                ->setEmail($email)
                ->setPassword($password)
                ->setFirstName($first_name)
                ->setLastName($last_name);
    
            $user_model->create($user);
        }
    }
}