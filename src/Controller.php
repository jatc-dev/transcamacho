<?php
declare(strict_types=1);

namespace App;

class Controller
{
    protected function render(string $view, array $data = []): string
    {
        extract($data, EXTR_SKIP);
        $viewPath = __DIR__ . '/../templates/' . $view . '.php';
        if (!file_exists($viewPath)) {
            http_response_code(404);
            return 'Vista no encontrada: ' . htmlspecialchars($view);
        }
        ob_start();
        include $viewPath;
        return ob_get_clean();
    }

    protected function redirect(string $url): void
    {
        header('Location: ' . $url, true, 302);
        exit;
    }

    protected function json(array $data, int $status = 200): void
    {
        http_response_code($status);
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($data, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        exit;
    }

    protected function input(string $key, mixed $default = null): mixed
    {
        $value = $_POST[$key] ?? $_GET[$key] ?? $default;
        return $value;
    }

    protected function csrfToken(): string
    {
        if (empty($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['csrf_token'];
    }

    protected function validateCsrf(string $token): bool
    {
        return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
    }
}
