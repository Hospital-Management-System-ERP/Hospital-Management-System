<?php

declare(strict_types=1);
require_once __DIR__ . '/../../config.php';
require __DIR__ . '/../../vendor/autoload.php';

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

define('COOKIE_NAME', 'hms_erp_tokens');
define('JWT_SECRET', $secret_key); // change to strong key from env/config
define('JWT_ALGO', 'HS256');

function login_url(): string
{
    return BASE_URL . 'login';
}
function require_auth(array $allowedRoles = []): array
{
    session_start();

    $token = $_COOKIE[COOKIE_NAME] ?? '';
    $login_url = login_url();

    if (!$token) {
        header("Location: $login_url");
        exit;
    }

    try {
        $decoded = JWT::decode($token, new Key(JWT_SECRET, JWT_ALGO));
        $user = (array) $decoded;

        // Role-based access check
        if (!empty($allowedRoles) && !in_array($user['role'], $allowedRoles, true)) {
            header("HTTP/1.1 403 Forbidden");
            echo "Access Denied";
            exit;
        }

        return $user;
    } catch (\Firebase\JWT\ExpiredException $e) {
        $_SESSION['last_page'] = $_SERVER['REQUEST_URI'];
        header("Location: $login_url?error=expired");
        exit;
    } catch (\Throwable $e) {
        session_destroy();
        header("Location: $login_url?error=invalid");
        exit;
    }
}
