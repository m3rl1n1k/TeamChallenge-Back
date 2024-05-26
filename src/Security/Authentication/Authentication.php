<?php

namespace App\Security\Authentication;

use App\Core\Config;
use App\Core\Exceptions\BadParameter;
use App\Core\Http\HttpStatusCode;
use App\Core\Http\Response;
use App\Core\Interface\AuthenticateInterface;
use App\Core\Security\Password;
use App\Core\Session;
use App\Repository\User;
use DateTime;
use Exception;
use Firebase\JWT\JWT;
use LogicException;

class Authentication implements AuthenticateInterface
{
    protected array $userCredentials;

    public function __construct(
        protected JWT  $jwt,
        protected User $user,
    )
    {
    }

    /**
     * @throws Exception
     */
    public function handle(array $userData): string|Response
    {
        $this->userCredentials = $userData;
        $email = $userData['email'];
        $password = $userData['password'];
        return $this->credentialsMatch($email, $password);
    }

    /**
     * @throws Exception
     */
    protected function onSuccess(): string
    {
        $token = $this->makeToken();
        Session::add([
            'token' => $token,
            'user' => $this->userCredentials['email']
        ]);
        return $token;
    }

    protected function onFail(): void
    {
        throw new BadParameter("Invalid credentials!");
    }

    /**
     * @throws Exception
     */
    protected function credentialsMatch(string $email, string $password)
    {
        $user = $this->user->findBy(['email' => $email]);
        $token = Session::get('token');
        $userInSession = Session::get('user');
        if ($token && $userInSession === $this->userCredentials['email']) {
            Session::remove(['token', 'user']);
            throw new LogicException("You already logged! Your token: $token");
        }
        if ($user['email'] === $email && Password::decrypt($password, $user['password'])) {
            return $this->onSuccess();
        }
        $this->onFail();
    }

    /**
     * @throws Exception
     */
    private function makeToken(): string
    {
        $payload = [
            "start" => (new DateTime())->getTimestamp(),
            "expired" => (new DateTime("+ " . Config::getValue('middleware.tokenExpTime') . " minute"))->getTimestamp(),
            "user" => $this->userCredentials
        ];
        $key = Config::getValue('middleware.token');
        return "Bearer " . $this->jwt::encode($payload, $key, 'HS256');
    }

    public function logout(): void
    {
        Session::stop();
    }
}