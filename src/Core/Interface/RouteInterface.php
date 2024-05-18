<?php

namespace App\Core\Interface;

interface RouteInterface
{
    public function get(string $uri, string $controller, string $action): RouteInterface;

    public function post(string $uri, string $controller, string $action): RouteInterface;

    public function put(string $uri, string $controller, string $action): RouteInterface;

    public function patch(string $uri, string $controller, string $action): RouteInterface;

    public function delete(string $uri, string $controller, string $action): RouteInterface;

    public function only(string $key): static;

    public function route(): void;
}