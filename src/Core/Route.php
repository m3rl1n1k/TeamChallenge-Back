<?php

namespace App\Core;


use App\Core\Container\Container;
use App\Core\Controller\Helper;
use App\Core\Interface\RouteInterface;
use BadMethodCallException;
use DiggPHP\Psr11\NotFoundException;
use Exception;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use ReflectionException;

class Route implements RouteInterface
{
    private array $routes;

    public function __construct(protected Request $request)
    {
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

    public function route(): void
    {
        $controller = $action = $args = null;
        $uriIn = $this->request->getUrl();
        $methodIn = $this->request->getMethod();

        foreach ($this->routes as $uri => $param) {

            $args = $this->getArguments($uri, $uriIn);
            $args = empty(!$args) ? $args : [];
            // якщо урл має патерн {show} тоді заміняєм його на значення яке передане в урлі
            $uri = $this->request->isPatternUri($uri) ? $this->getParams($uri, $uriIn, true) : $uri;

            // Перевіряємо, чи співпадає URI та метод
            if ($uriIn === $uri && strtoupper($methodIn) === $param['method']) {
                $controller = $param['controller'];
                $action = $param['action'];
                break;
            }
        }
        //Перевірка наявності контролкера
        if (is_null($controller)) {
            Helper::printError('Controller %s or route "%s" not found!', $controller, $uriIn);
        }
        // Викликаємо метод контролера з переданими аргументами
        $this->callController($controller, $action, $args);
    }

    /**
     * @throws Exception
     */
    private function getParams(string $uri, string $uriIn, $replace = false): array|string
    {
        //get params from URL-line with GET-request
        $value = null;
        //перевірка на співпадіння з урлом вхідним
        $matchedURL = $this->request->isPatternUri($uri);
        //перевірка на те чи має вхідний урл id з патерном {id}
        $idIn = $this->request->isPatternUri($uriIn, '/\d+$/');
        // Id always must be as number only
        if (!preg_match('/\/\d+$/', "/" . $idIn[0])) {
            throw new Exception("Id must be only numbers!");
        }
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

    /**
     * @throws NotFoundExceptionInterface
     * @throws ReflectionException
     * @throws NotFoundException
     * @throws ContainerExceptionInterface
     */
    private function callController(string $controller, string $action, array|string $args): void
    {
        if (!class_exists($controller)) {
            throw new NotFoundException("Controller $controller not found!");
        }
        if (!method_exists($controller, $action)) {
            throw new BadMethodCallException("Method $action() not found!");
        }
        $controller = Container::getInstance()->get($controller);
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

    }

    protected function getArguments(string $uri, string $uriIn): null|array|string
    {
        //отримуєм аргументи з адресного рядка
        $arg = $this->getParams($uri, $uriIn);

        $request = $this->request->getRequestBody($uri);
        // merge all data into one array and return
        return array_merge($arg, $request ?? []);
    }

    protected function getKey(string $uri): string
    {
        $key = $this->request->isPatternUri($uri);
        if ($key) {
            $key = str_replace("/", '', $key[0]);
            $key = str_replace("{", '', $key);
            return str_replace("}", '', $key);
        }
        return "arg";
    }


}