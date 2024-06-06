<?php

namespace App\Core\Route;

use App\Core\Interface\RouteInterface;
use DiggPHP\Psr11\NotFoundException;
use Override;

class Route implements RouteInterface
{

    private array $routes;

    public function __construct(protected RouteService $routeService)
    {
    }

    public static function configRoute(): void
    {
        require_once ROOT . 'config/route.php';
    }

    #[Override] public function get($uri, $controller, $action): Route
    {
        return $this->add($uri, $controller, $action, "GET");
    }

    protected function add(string $uri, string $controller, string $action, string $method): Route
    {

        $this->routes[$method . "." . $uri] = [
            'controller' => $controller,
            'action' => $action,
            'method' => $method,
        ];
        return $this;
    }

    #[Override] public function post($uri, $controller, $action): Route
    {
        return $this->add($uri, $controller, $action, "POST");
    }

    #[Override] public function put($uri, $controller, $action): Route
    {
        return $this->add($uri, $controller, $action, "PUT");
    }

    #[Override] public function patch($uri, $controller, $action): Route
    {
        return $this->add($uri, $controller, $action, "PATCH");
    }

    #[Override] public function delete($uri, $controller, $action): Route
    {
        return $this->add($uri, $controller, $action, "DELETE");
    }

    #[Override] public function only(string $key): static
    {
        $this->routes[array_key_last($this->routes)]['middleware'] = $key;
        return $this;
    }

    /**
     * @throws NotFoundException
     */
    #[Override] public function route(): void
    {
        $this->routeService->build($this->routes);
    }
}