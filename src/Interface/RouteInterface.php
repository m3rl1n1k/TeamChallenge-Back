<?php

namespace App\Interface;

interface RouteInterface
{
    public function get(string $uri, string $controller, string $action): void;

    public function post(string $uri, string $controller, string $action): void;

    public function put(string $uri, string $controller, string $action): void;

    public function patch(string $uri, string $controller, string $action): void;

    public function delete(string $uri, string $controller, string $action): void;

    public function route(): void;
}