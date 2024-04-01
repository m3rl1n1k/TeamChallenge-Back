<?php

namespace App\Core\Security;

class Password
{

    public static function decrypt(string $password, $hash): bool
    {
        return password_verify($password, $hash);
    }

    public static function encrypt(string $password, string $algo = PASSWORD_BCRYPT)
    {
        return password_hash($password, $algo);
    }
}