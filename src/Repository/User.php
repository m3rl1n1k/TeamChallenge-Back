<?php

namespace App\Repository;

use App\Core\ConnectionDB;
use App\Core\Security\Password;
use Error;
use PDO;

class User
{
    public function get(string $email)
    {
        $db = ConnectionDB::getInstance();
        $sql = "select * from user where email = :email";
        $user = $db->prepare($sql);
        $user->execute(['email' => $email]);
        return $user->fetch(PDO::FETCH_ASSOC);
    }

    public function setUser(array $userData): bool
    {
        $db = ConnectionDB::getInstance();
        $email = $userData['email'];
        $password = Password::encrypt($userData['password']);
        $name = $userData['name'];
        $this->userIsset($email);
        $sql = "INSERT INTO user (email, password, name) VALUES (:email, :password, :name)";
        $res = $db->prepare($sql);
        return $res->execute(['email' => $email, 'password' => $password, 'name' => $name]);
    }

    protected function userIsset(string $email): void
    {
        $user = $this->get($email);
        if (!empty($user['email'])) {
            throw new Error('User already is registered!');
        }
    }
}