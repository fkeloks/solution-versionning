<?php

namespace ESGI\Helpers;

class Route
{
    /**
     * Returns url of a named route
     *
     * @param string $controller
     * @param string $action
     *
     * @return string
     */
    public static function getUrl(string $controller, string $action = ''): string
    {
        $cache = BASE_PATH . DIRECTORY_SEPARATOR . 'cache' . DIRECTORY_SEPARATOR . 'routes.cache.php';
        if (file_exists($cache)) {
            $routes = include $cache;
        } else {
            $routes = yaml_parse_file('../routes.yml');
        }

        $baseUrl = self::getBaseUrl();

        foreach ($routes as $path => $route) {
            if ((isset($route['name']) && $route['name'] === $controller) || ($route['controller'] === $controller && $route['action'] === $action)) {
                return $baseUrl . $path;
            }
        }

        return $baseUrl;
    }

    /**
     * Returns configured base url
     *
     * @return string
     */
    public static function getBaseUrl(): string
    {
        return $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['SERVER_NAME'] . ((int)$_SERVER['SERVER_PORT'] === 80 ? '' : ':' . $_SERVER['SERVER_PORT']);
    }

    /**
     * Returns current url
     *
     * @return string
     */
    public static function getCurrentUrl(): string
    {
        return preg_replace('/\?.*$/', '', $_SERVER['REQUEST_URI']);
    }

    /**
     * Determine and returns current route
     *
     * @return string
     */
    public static function getCurrentRoute(): string
    {
        $url = self::getCurrentUrl();
        $routes = yaml_parse_file(BASE_PATH . DIRECTORY_SEPARATOR . 'routes.yml');

        if (array_key_exists($url, $routes)) {
            return $routes[$url]['name'] ?? '';
        }

        return '';
    }

    /**
     * Redirect client to a route
     *
     * @param string $route
     * @param array $params
     */
    public static function redirect(string $route, array $params = []): void
    {
        header('Location: ' . self::getUrl($route) . (!empty($params) ? '?' . http_build_query($params) : ''));
        exit();
    }
}
