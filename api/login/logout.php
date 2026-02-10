<?php
declare(strict_types=1);
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Pragma: no-cache");
header("Expires: 0");

require __DIR__ . '/../../config.php';

define('COOKIE_NAME', 'hms_erp_tokens');

session_start();
session_unset();
session_destroy();

// Delete session cookie
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(
        session_name(),
        '',
        time() - 42000,
        $params["path"],
        $params["domain"],
        $params["secure"],
        $params["httponly"]
    );
}

// Blacklist JWT token
$token = $_COOKIE[COOKIE_NAME] ?? '';
if ($token) {
    $stmt = $conn->prepare("INSERT INTO jwt_blacklist (token) VALUES (?)");
    if ($stmt) {
        $stmt->bind_param("s", $token);
        $stmt->execute();
        $stmt->close();
    }
}

// Delete JWT cookie
setcookie(COOKIE_NAME, '', [
    'expires'  => time() - 3600,
    'path'     => '/',
    'secure'   => (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off'),
    'httponly' => true,
    'samesite' => 'Strict'
]);

// Redirect to login
header('Location: ' . BASE_URL . 'login?error=logout');
exit;
