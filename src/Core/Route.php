<?php

namespace App\Core;


use App\Interface\RouteInterface;
use BadMethodCallException;

class Route implements RouteInterface
{
    private array $urls;
    private Request $request;

    public function __construct()
    {
        $this->request = new Request();
    }

    protected function add(string $uri, string $controller, string $action, string $method): void
    {

        $this->urls[$uri] = [
            'controller' => $controller,
            'action' => $action,
            'method' => $method,
        ];
    }

    public function get($uri, $controller, $action): Route
    {
        $this->add($uri, $controller, $action, "GET");
        return $this;
    }

    public function post($uri, $controller, $action): void
    {
        $this->add($uri, $controller, $action, "POST");
    }

    public function put($uri, $controller, $action): void
    {
        $this->add($uri, $controller, $action, "PUT");
    }

    public function patch($uri, $controller, $action): void
    {
        $this->add($uri, $controller, $action, "PATCH");
    }

    public function delete($uri, $controller, $action): void
    {
        $this->add($uri, $controller, $action, "DELETE");
    }


    public function route($uriIn, $methodIn): void
    {
        $controller = $action = $args = null;

        foreach ($this->urls as $uri => $param) {
            //отримуєм аргументи з адресного рядка
            $arg = $this->getArg($uri, $uriIn);

            // отримуємо тіло запиту
            $request = $this->request->getContent();

            // якщо тіло то передаєм агрумент в противному випадку передаєтья тіло
            $args = empty($request) ? $arg : $request;

            // якщо урл має патерн {show} тоді створюєм масив зі значенням з переданого укрла ззовні [show => 6]
            $uri = preg_match('/{[A-Za-z]+}/', $uri) ? $this->getArg($uri, $uriIn, true) : $uri;

            // Перевіряємо, чи співпадає URI та метод
            $method = strtoupper($methodIn) === $param['method'];
            if ($uriIn === $uri && $method) {
                $controller = $param['controller'];
                $action = $param['action'];
                break;
            }
        }
        // Викликаємо метод контролера з переданими аргументами
        if (is_null($controller)) {
            Helper::printError("Page %s Not Found!", $uriIn);
        }
        $this->callController($controller, $action, $args);
    }

    private function getArg(string $uri, string $uriIn, $replace = false): array|string
    {
        $key = $id = null;
        //перевірка на те чи має вхідний урл id
        $uriIn = preg_match('/\/(\d+)$/', $uriIn, $matches);
        if ($uriIn) {
            $id = $matches[1];
            if (preg_match('/{[A-Za-z]+}/', $uri, $matches)) {
                $key = trim($matches[0], '{}');
            }
        }
        //
        if ($replace) {
            return str_replace($matches[0], $id, $uri);
        }
        return $id ? [$key => $id] : [];
    }

    private function callController(string $controller, string $action, array|string $args): void
    {
        if (!method_exists($controller, $action)) {
            throw new BadMethodCallException("Method $action()  not found!");
        }
        $controller = new $controller();
        if (is_string($args)) {
            call_user_func_array([$controller, $action], []);
        } else {
            call_user_func_array([$controller, $action], $args);
        }
    }
}