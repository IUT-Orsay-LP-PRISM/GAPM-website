<?php

namespace App\controllers;

class Router {
    private array $routes = [];

    public function addRoute($url, $controller, $method): void
    {
        $this->routes[] = [
            'url' => '/\?action='. $url,
            'controller' => $controller,
            'method' => $method
        ];
    }

    public function handleRequest($requestUrl): void
    {
        global $entityManager;
        $url = $_SERVER['REQUEST_URI'];
        $queryString = parse_url($url, PHP_URL_QUERY);
        $queryParams = [];
        if (!empty($queryString)) {
            parse_str($queryString, $queryParams);
        }

        foreach ($this->routes as $route) {
            $pattern = $this->convertUrlToPattern($route['url']);
            if (preg_match($pattern, $requestUrl, $matches)) {
                $controllerClass = 'App\\controllers\\' . $route['controller'];
                $method = $route['method'];
                $controller = new $controllerClass($entityManager);

                // Fusionner les paramètres de la route avec les paramètres de la requête
                $params = array_merge($queryParams, $this->extractParams($matches));

                $controller->$method($params);
                return;
            }
        }

        // Route par défaut si aucune correspondance
        $controller = new HomeController($entityManager);
        $controller->index();
    }

    private function convertUrlToPattern($url): string
    {
        $pattern = preg_replace('/\//', '\/', $url);
        $pattern = preg_replace('/\{([^}]+)\}/', '(?P<$1>[^\/]*)', $pattern);
        $pattern = preg_replace('/<([^>]+)>/', '(?P<$1>[^\/]*)', $pattern);
        return '/^' . $pattern . '$/';
    }

    private function extractParams($matches): array
    {
        $params = [];
        foreach ($matches as $key => $value) {
            if (!is_numeric($key)) {
                $params[$key] = $value;
            }
        }
        return $params;
    }
}