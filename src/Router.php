<?php

namespace App;

use App\Controller;

class Router
{
    private const METHOD_GET = 'GET';
    private const METHOD_POST = 'POST';
    private const METHOD_PUT = 'PUT';
    private const METHOD_DELETE = 'DELETE';

    private const ERROR_404 = 'HTTP/1.0 404 Not Found';
    private const ERROR_500 = 'HTTP/1.0 500 Internal Server Error';

    private $config = [
        'counter/{id}' => [
            self::METHOD_GET => [
                Controller\CounterController::class,
                'getOne'
            ]
        ],
        'counter' => [
            self::METHOD_GET => [
                Controller\CounterController::class,
                'getAll'
            ]
        ],
    ];

    public function run(string $method, string $uri): void
    {
        $key = $this->prepareKey($uri);
        if (!isset($this->config[$key]) && !isset($this->config[$key][$method])) {
            $this->return404();
        }

        if (
            !is_array($this->config[$key][$method])
            || count($this->config[$key][$method]) != 2
            || !class_exists($this->config[$key][$method][0])
        ) {
            $this->returnBadConfig();
        }


        $controller = new $this->config[$key][$method][0];
        $controllerMethod = $this->config[$key][$method][1];
        if (!method_exists($controller, $controllerMethod)) {
            $this->returnBadConfig();
        }

        $parameters = $this->getUriParameters($key, $uri);
        try {
            $controller->$controllerMethod(...$parameters);
        } catch (\Throwable $e) {
            $this->return500($e->getMessage());
        }
    }

    private function return404(): void
    {
        header(self::ERROR_404);
        echo 'Error 404';
        exit;
    }

    private function returnBadConfig(): void
    {
        $this->return500('Bad config');
        exit;
    }

    private function return500(string $error): void
    {
        header(self::ERROR_500);
        echo $error;
        exit;
    }

    private function prepareKey(string $uri): string
    {
        return trim(preg_replace('/\/\d*(\/|$)/', '/{id}/', $uri), '/');
    }

    private function getUriParameters(string $key, string $uri): array
    {
        $parameters = [];
        $keyParameters = explode('/', $key);
        $uriParameters = explode('/', $uri);
        foreach ($keyParameters as $index => $keyParameter) {
            if (
                $keyParameter[0] == '{'
                && $keyParameter[-1] == '}'
                && isset($uriParameters[$index])
            ) {
                $parameters[] = $uriParameters[$index];
            }
        }

        return $parameters;
    }
}
