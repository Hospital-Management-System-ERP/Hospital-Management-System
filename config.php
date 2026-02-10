<?php
require __DIR__ . '/vendor/autoload.php';
use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

if (!defined('BASE_URL')) {
    if (in_array($_SERVER['HTTP_HOST'], ['localhost', '127.0.0.1'])) {
        $baseFolder = basename(__DIR__);
        define("BASE_URL", "/" . $baseFolder . "/");
    } else {
        define("BASE_URL", "/");
    }
}

$dbname = getenv('DB_NAME') ?: '';
$host = getenv('DB_HOST') ?: 'localhost';
$db_username = getenv('DB_USER') ?: 'root';
$db_password = getenv('DB_PASS') ?: '';

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
try {
    $conn = new mysqli($host, $db_username, $db_password, $dbname);
    $conn->set_charset("utf8mb4");
} catch (mysqli_sql_exception $e) {
    error_log($e->getMessage());
    die('Database Connection Failed');
}

$envKey = getenv('APP_SECRET_KEY') ?: $_ENV['APP_SECRET_KEY'] ?? null;
if (!$envKey || strlen($envKey) < 32) {
    $secret_key = bin2hex(random_bytes(32));
    error_log("APP_SECRET_KEY missing or too short! Using fallback key: $secret_key");
} else {
    $secret_key = $envKey;
}
