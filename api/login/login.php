<?php

declare(strict_types=1);
session_start();
date_default_timezone_set('Asia/Kolkata');
require __DIR__ . '/../../vendor/autoload.php';
require __DIR__ . '/../../config.php';

use Firebase\JWT\JWT;

define('JWT_SECRET', $secret_key);
define('JWT_ALGO', 'HS256');
define('COOKIE_NAME', 'hms_erp_tokens');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: " . BASE_URL . "login?error=method");
    exit;
}

$username = trim($_POST['username'] ?? '');
$password = trim($_POST['password'] ?? '');
$role = strtolower(trim($_POST['role'] ?? ''));

if ($username == '' || $password == '' || $role == '') {
    header("Location: ../../login?error=required");
    exit;
}

$roleTableMap = [
    'admin'         => ['table' => 'admin', 'hasRole' => false],
    'doctor'        => ['table' => 'tbl_doctor', 'hasRole' => false],
    // Staff Roles
    'nurse'         => ['table' => 'tbl_staff', 'hasRole' => true],
    'accountant'    => ['table' => 'tbl_staff', 'hasRole' => true],
    'support'       => ['table' => 'tbl_staff', 'hasRole' => true],
    'pharmacy'      => ['table' => 'tbl_staff', 'hasRole' => true],
    'laboratory'    => ['table' => 'tbl_staff', 'hasRole' => true],
    'radiology'     => ['table' => 'tbl_staff', 'hasRole' => true],
    'patient_coordinator' => ['table' => 'tbl_staff', 'hasRole' => true],
    'ot_coordinator' => ['table' => 'tbl_staff', 'hasRole' => true],
    'ambulance_coordinator' => ['table' => 'tbl_staff', 'hasRole' => true],
    'inventory_manager' => ['table' => 'tbl_staff', 'hasRole' => true],
    'patient' => ['table' => 'tbl_staff', 'hasRole' => true]
];

if (!isset($roleTableMap[$role])) {
    header("Location:" . BASE_URL . "login?error=invalid_role");
    exit;
}

$config = $roleTableMap[$role];
$table  = $config['table'];

if ($config['hasRole']) {
    $sql = $conn->prepare("
            SELECT id, name, username, password, role 
            FROM $table 
            WHERE username = ? AND role = ?
            LIMIT 1
        ");
    $sql->bind_param('ss', $username, $role);
} else {
    $sql = $conn->prepare("
            SELECT id, name, username, password 
            FROM $table 
            WHERE username = ?
            LIMIT 1
        ");
    $sql->bind_param('s', $username);
}

$sql->execute();
$result = $sql->get_result();
$user = $result->fetch_assoc();

if (
    !$user ||
    !password_verify($password, $user['password']) ||
    ($config['hasRole'] && $role !== $user['role'])
) {
    header("Location:" . BASE_URL . "login?error=invalid");
    exit;
}
$permissions = [];
if ($config['hasRole']) {
    $permStmt = $conn->prepare("
        SELECT p.permission_key
        FROM staff_permissions sp
        JOIN permissions p ON sp.permission_id = p.id
        WHERE sp.staff_id = ?
    ");
    $permStmt->bind_param('i', $user['id']);
    $permStmt->execute();
    $permResult = $permStmt->get_result();
    while ($row = $permResult->fetch_assoc()) {
        $permissions[] = $row['permission_key'];
    }
}

$issuedAt = time();
$expired = $issuedAt + 7200;

$payload = [
    'iss'  => 'hospital-erp',
    'iat'  => $issuedAt,
    'exp'  => $expired,
    'sub'  => $user['id'],
    'name' => $user['name'],
    'username' => $user['username'],
    'role' => $role,
    'table' => $table,
    'permissions' => $permissions
];
if ($config['hasRole']) {
    $payload['permissions'] = $permissions;
}

$jwt = JWT::encode($payload, JWT_SECRET, JWT_ALGO);
// $_SESSION['jwt'] = $jwt;

setcookie(COOKIE_NAME, $jwt, [
    'expires' => $expired,
    'path' => '/',
    'secure' => (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off'),
    'httponly' => true,
    'samesite' => 'Strict'
]);

header('Location:' . BASE_URL . 'index');
exit;
