<?php

namespace App\Core;


use App\Interface\RouteInterface;
use BadMethodCallException;

class Route implements RouteInterface
{
    private array $urls;

    public function __construct(protected Request $request)
    {
    }

    protected function add(string $uri, string $controller, string $action, string $method): Route
    {

        $this->urls[$uri] = [
            'controller' => $controller,
            'action' => $action,
            'method' => $method,
        ];
        return $this;
    }

    public function get($uri, $controller, $action): Route
    {
        return $this->add($uri, $controller, $action, "GET");
    }

    public function post($uri, $controller, $action): Route
    {
        return $this->add($uri, $controller, $action, "POST");
    }

    public function put($uri, $controller, $action): Route
    {
        return $this->add($uri, $controller, $action, "PUT");
    }

    public function patch($uri, $controller, $action): Route
    {
        return $this->add($uri, $controller, $action, "PATCH");
    }

    public function delete($uri, $controller, $action): Route
    {
        return $this->add($uri, $controller, $action, "DELETE");
    }


    public function route(): void
    {
        $controller = $action = $args = null;
        $uriIn = $this->request->getUrl();
        $methodIn = $this->request->getMethod();

        foreach ($this->urls as $uri => $param) {
            //отримуєм аргументи з адресного рядка
            $arg = $this->getArg($uri, $uriIn);

            // отримуємо тіло запиту
            $request = $this->request->withName(array_key_first($arg) ?? "request")->getContent();

            // якщо тіло то передаєм агрумент в противному випадку передаєтья тіло
            $args = empty($request) ? $arg : $request;

            // якщо урл має патерн {show} тоді заміняєм його на значення яке передане в урлі
            $uri = preg_match('/{[A-Za-z]+}/', $uri) ? $this->getArg($uri, $uriIn, true) : $uri;

            // Перевіряємо, чи співпадає URI та метод
            if ($uriIn === $uri && strtoupper($methodIn) === $param['method']) {
                $controller = $param['controller'];
                $action = $param['action'];
                break;
            }
        }
        //Перевірка наявності контролкера
        if (is_null($controller)) {
            Helper::printError('Controller %s not found!', $controller);
        }
        // Викликаємо метод контролера з переданими аргументами
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

    public static function configRoute(): void
    {
        require_once ROOT . 'config/route.php';
    }

    public function only($key)
    {
        echo($key);
    }
}