<?php

class Route
{
    private static $prefix = '';
    private static $middlewares = [];
    private static $routes = [];

    public static function group($attributes, $callback)
    {
        $oldPrefix = self::$prefix;
        $oldMiddlewares = self::$middlewares;

        self::$prefix .= $attributes['prefix'] ?? '';
        self::$middlewares = array_merge(self::$middlewares, $attributes['middleware'] ?? []);

        call_user_func($callback);

        self::$prefix = $oldPrefix;
        self::$middlewares = $oldMiddlewares;
    }

    public static function get($route, $handler)
    {
        self::$routes['GET'][self::$prefix . $route] = [
            'handler' => $handler,
            'middlewares' => self::$middlewares
        ];
    }

    public static function post($route, $handler)
    {
        self::$routes['POST'][self::$prefix . $route] = [
            'handler' => $handler,
            'middlewares' => self::$middlewares
        ];
    }

    public static function run()
    {
        $requestMethod = $_SERVER['REQUEST_METHOD'];
        $route = explode('?', $_SERVER['REQUEST_URI'])[0];

        if (!isset(self::$routes[$requestMethod])) {
            self::$routes[$requestMethod] = [];
        }

        try {
            $handler = self::getMatchedRouteHandler($route, $requestMethod);

            if ($handler) {
                $parameters = $handler['parameters'] ?? null;
                $routeHandler = $handler['handler'] ?? null;
                $middlewares = $handler['middlewares'] ?? [];

                $nextMiddleware = function () use ($routeHandler, $parameters) {
                    if ($routeHandler) {
                        [$controllerClass, $method] = $routeHandler;

                        if (class_exists($controllerClass) && method_exists($controllerClass, $method)) {
                            $request = new Request($parameters);
                            (new $controllerClass)->$method($request);
                        } else {
                            throw new Exception('Controller or method not found.', 404);
                        }
                    } else {
                        throw new Exception('Route handler not found.', 404);
                    }
                };

                foreach (array_reverse($middlewares) as $middlewareName) {
                    $middlewareClass = self::$middlewares[$middlewareName] ?? null;

                    if ($middlewareClass && class_exists($middlewareClass)) {
                        $middlewareInstance = new $middlewareClass;
                        $nextMiddleware = function () use ($middlewareInstance, $nextMiddleware) {
                            $middlewareInstance->handle($nextMiddleware);
                        };
                    }
                }

                $nextMiddleware();
            } else {
                throw new Exception('Route not found.', 404);
            }
        } catch (Exception $e) {
            $errorController = new ErrorHandler();
            $errorController->handle($e->getCode(), $e->getMessage());
        }
    }

    private static function getMatchedRouteHandler($route, $requestMethod)
    {
        $routeHandlers = self::$routes[$requestMethod];

        foreach ($routeHandlers as $routePattern => $routeHandler) {
            $routeRegex = self::getRouteRegex($routePattern);

            if (preg_match($routeRegex, $route, $matches)) {
                $parameters = [];
                $url = array_shift($matches);
                $pattern = "#^" . str_replace(['{', '}'], ['(?P<', '>\w+)'], $route) . "$#";

                if (preg_match($pattern, $url, $matches)) {
                    foreach ($matches as $key => $value) {
                        if (is_string($key)) {
                            $parameters[$key] = $value;
                        }
                    }
                } else {
                    throw new Exception('URL does not match pattern.', 404);
                }

                return ['handler' => $routeHandler['handler'], 'parameters' => $parameters, 'middlewares' => $routeHandler['middlewares']];
            }
        }

        return false;
    }

    private static function getRouteRegex($routeRegex)
    {
        preg_match_all('/\{(\w+)\}/', $routeRegex, $matches);

        foreach ($matches[0] as $i => $match) {
            $routeRegex = str_replace($match, '(\w+)', $routeRegex);
        }

        return '#^' . $routeRegex . '$#';
    }
}

