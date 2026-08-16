<?php
class Router
{
    public static function dispatch(): void
    {
 
        $uri = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH);
        $uri = rtrim($uri, '/');
        if ($uri === '') {
            $uri = '/';
        }

        switch ($uri) {

            case '/':
            case '/pos':
                $controller = new POSController();
                $controller->index();
                break;
            default:
                http_response_code(404);
                echo "404 - Page introuvable : " . htmlspecialchars($uri);
                break;
        }
    }
}
