<?php

namespace App\Controller;

use App\Entity\User as EntityUser;
use App\Model\User as ModelUser;

class User
{
    public function list()
    {
        $user_model = new ModelUser();

        $users = $user_model->findAll();

        return json_encode($users, JSON_UNESCAPED_UNICODE);
    }

    public function fill()
    {
        $user_model = new ModelUser();

        $user = new EntityUser();        


        for ($i = 0; $i < 30; $i++) {
            $faker = \Faker\Factory::create('fr_FR');
    
            $unwanted_chars = [
                'À'=>'A', 'Â'=>'A', 'Ä'=>'A', 'Æ'=>'A', 'Ç'=>'C', 'È'=>'E', 'É'=>'E',
                'Ê'=>'E', 'Ë'=>'E', 'Î'=>'I', 'Ï'=>'I', 'Ô'=>'O', 'Ö'=>'O', 'Ù'=>'U',
                'Ú'=>'U', 'Û'=>'U', 'Ü'=>'U', 'à'=>'a', 'â'=>'a', 'ä'=>'a', 'æ'=>'a', 'ç'=>'c',
                'è'=>'e', 'é'=>'e', 'ê'=>'e', 'ë'=>'e', 'î'=>'i', 'ï'=>'i', 'ñ'=>'n', 'ô'=>'o'
            ];
    
            $first_name = $faker->firstName();
            $last_name = $faker->lastName();
            $email = strtolower(strtr($first_name . '.' . $last_name, $unwanted_chars)) . '@' . $faker->freeEmailDomain();
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