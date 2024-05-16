<?php

namespace App\Repository;

use App\Core\DB\ConnectionDB;
use App\Core\Security\Password;
use Error;
use PDO;

class User
{
    protected ?PDO $db;

    public function __construct()
    {
        $this->db = ConnectionDB::getInstance();
    }

    public function get(string $email)
    {
        $sql = "select * from user where email = :email";
        $user = $this->db->prepare($sql);
        $user->execute(['email' => $email]);
        return $user->fetch(PDO::FETCH_ASSOC);
    }

    public function setUser(array $userData): bool
    {
        $email = $userData['email'];
        $password = Password::encrypt($userData['password']);
        $name = $userData['name'];
        $this->userIsset($email);
        $sql = "INSERT INTO user (email, password, name) VALUES (:email, :password, :name)";
        $res = $this->db->prepare($sql);
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