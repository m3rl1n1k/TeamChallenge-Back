<?php

namespace App\Core;

use App\Core\Container\Container;
use App\Core\Http\Request;
use App\Core\Interface\RouteInterface;
use App\Core\Security\Middleware;
use BadMethodCallException;
use DiggPHP\Psr11\NotFoundException;
use Override;

class Route implements RouteInterface
{
    private array $routes;

    public function __construct(protected Request $request, protected Middleware $middleware)
    {
    }

    public static function configRoute(): void
    {
        require_once ROOT . 'config/route.php';
    }

    protected function add(string $uri, string $controller, string $action, string $method): Route
    {

        $this->routes[$uri] = [
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

    #[Override] public function route(): void
    {
        $controller = $action = $args = null;
        $uriIn = $this->request->getUrl();
        $methodIn = $this->request->getMethod();
        foreach ($this->routes as $route => $param) {

            $args = $this->getArguments($route, $uriIn);
            $args = empty(!$args) ? $args : [];
            // якщо урл має патерн {show} тоді заміняєм його на значення яке передане в урлі
            $route = $this->request->isPatternUri($route) ? $this->getParams($route, $uriIn, true) : $route;
            // Перевіряємо, чи співпадає URI та метод
            if ($uriIn === $route && strtoupper($methodIn) === $param['method']) {
                $controller = $param['controller'];
                $action = $param['action'];
                $this->middleware->middleware($param['middleware']);
                break;
            }

        }
        //Перевірка наявності контролкера
        if (is_null($controller)) {
            throw new NotFoundException("Controller $controller or route $uriIn not found!");
        }
        // Викликаємо метод контролера з переданими аргументами
        $this->callController($controller, $action, $args);
    }

    /**
     * @throws NotFoundException
     */
    private function callController(string $controller, string $action, array|string $args): void
    {

        if (!class_exists($controller)) {
            throw new NotFoundException("Controller $controller not found!");
        }
        if (!method_exists($controller, $action)) {
            throw new BadMethodCallException("Method $action() not found!");
        }
        $controller = Container::call($controller);
        if (is_string($args)) {
            call_user_func_array([$controller, $action], []);
        } else {
            call_user_func_array([$controller, $action], $args);
        }
    }

    protected function getArguments(string $uri, string $uriIn): null|array|string
    {
        //отримуєм аргументи з адресного рядка
        $arg = $this->getParams($uri, $uriIn);
        unset($request);
        $request = $this->request->getRequestBody();
        // merge all data into one array and return
        return array_merge($arg, $request ?? []);
    }

    private function getParams(string $uri, string $uriIn, $replace = false): array|string
    {
        //get params from URL-line with GET-request
        $value = null;
        //перевірка на співпадіння з урлом вхідним
        $matchedURL = $this->request->isPatternUri($uri);
        //перевірка на те чи має вхідний урл id з патерном {id}
        $idIn = $this->request->isPatternUri($uriIn, '/\d+$/');
        // Id always must be as number only
        $incomeURl = $this->request->isPatternUri($uriIn, '/[a-zA-Z]+$/');

        if ($matchedURL) {
            if ($incomeURl) {
                //if they same, then get value $key as {type} from $uri and $value as /shoes
                $value = substr($incomeURl[0], 0);
            }
            if ($idIn) {
                $value = "$idIn[0]";
            }
        }
        if ($replace) {
            return str_replace($matchedURL[0], "/" . $value, $uri);
        }
        // отримання параметрів з GET
        if ($uri === $uriIn && $this->request->getMethod() === 'GET') {
            return $this->request->getParams();
        }
        $key = $this->getKey($uri);
        return $value ? [$key => $value] : [];
    }

    protected function getKey(string $uri): string
    {
        $key = $this->request->isPatternUri($uri);
        if ($key) {
            return str_replace(["/", "{", "}"], '', $key[0]);
        }
        return "arg";
    }

    public function only(string $key): static
    {
        $this->routes[array_key_last($this->routes)]['middleware'] = $key;
        return $this;
    }
}