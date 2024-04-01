<?php

namespace App\Core;

use App\Core\Interface\SessionInterface;
use Override;

class Session implements SessionInterface
{
    protected array $session;

    public function __construct()
    {
        $this->sessionStart();
        $this->setSession();
    }

    #[Override] public function getSession(): array
    {
        return $this->session;
    }

    #[Override] public function addToSession(string $key, mixed $value): void
    {
        $this->session[$key] = $value;
    }

    #[Override] public function removeFromSession(string $key): void
    {
        unset($this->session[$key]);
    }

    public function getFromSession(string $key): mixed
    {
        return $this->session[$key];
    }

    protected function sessionStart($options = []): void
    {
        session_start($options);
    }

    protected function setSession(): void
    {
        $this->session = $_SESSION;
    }
}