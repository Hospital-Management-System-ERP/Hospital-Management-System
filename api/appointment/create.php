<?php
ob_start();
date_default_timezone_set('Asia/Kolkata');
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/../../config.php';
require_once __DIR__ . '/appoinmentMail.php';
header("Content-Type: application/json");

try {
    if ($_SERVER['REQUEST_METHOD'] != "POST") {
        echo json_encode(['success' => false, 'message' => 'Only POST Method Allowed']);
        exit;
    }
    if (!isset($_SESSION['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        echo json_encode(['success' => false, 'message' => 'Invalid CSRF Tokens']);
        exit;
    }
    function generateAppointmentId($conn)
    {
        $date = date("Ymd");
        $sql = "SELECT COUNT(*) as total FROM appointments WHERE DATE(created_at)=CURDATE()";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
        $next = $row['total'] + 1;
        $serial = str_pad($next, 3, "0", STR_PAD_LEFT);
        return "APT-$date-$serial";
    }
    $appointment_uid = generateAppointmentId($conn);
    $name = trim($_POST['name'] ?? '');
    $mobile = trim($_POST['mobile'] ?? '');
    $email = filter_var(trim($_POST['email'] ?? ''), FILTER_SANITIZE_EMAIL);
    $age = trim($_POST['age'] ?? '');
    $gender = trim($_POST['gender'] ?? '');
    $address = trim($_POST['address'] ?? '');
    $service = trim($_POST['service'] ?? '');

    if ($name == '') {
        echo json_encode(['success' => false, 'message' => 'Enter Name']);
        exit;
    } elseif ($mobile == '') {
        echo json_encode(['success' => false, 'message' => 'Enter Mobile No']);
        exit;
    } elseif (!preg_match('/^[0-9]{10}$/', $mobile)) {
        echo json_encode(['success' => false, 'message' => 'Enter 10 Digit Mobile No.']);
        exit;
    } elseif (!empty($email) && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(['success' => false, 'message' => 'Enter Valid Email Id']);
        exit;
    } elseif ($age == '') {
        echo json_encode(['success' => false, 'message' => 'Enter Age']);
        exit;
    } elseif (!filter_var($age, FILTER_VALIDATE_INT)) {
        echo json_encode(['success' => false, 'message' => 'Age must be a number']);
        exit;
    } elseif ($gender == '') {
        echo json_encode(['success' => false, 'message' => 'Select Gender']);
        exit;
    } elseif ($address == '') {
        echo json_encode(['success' => false, 'message' => 'Enter Address']);
        exit;
    } elseif ($service == '') {
        echo json_encode(['success' => false, 'message' => 'Select Service']);
        exit;
    }
    $age = (int)$age;
    $specialization = '';
    $doctor = '';
    $services = [];
    $date = '';
    $service_cycle = '';
    $from_date = '';
    $to_date = '';
    $time = '';
    if ($service === 'clinic' || $service === 'video') {
        $specialization = $_POST['specialization'] ?? '';
        $doctor = $_POST['doctor'] ?? '';
        $date = $_POST['doa'] ?? '';
        $time = $_POST['appointment_time'] ?? '';

        if ($specialization == '') {
            echo json_encode(['success' => false, 'message' => 'Select Specialization']);
            exit;
        }
        if ($doctor == '') {
            echo json_encode(['success' => false, 'message' => 'Select Doctor']);
            exit;
        }
        if ($date == '') {
            echo json_encode(['success' => false, 'message' => 'Enter Date']);
            exit;
        }
        if ($time == '') {
            echo json_encode(['success' => false, 'message' => 'Enter Time']);
            exit;
        }
    } elseif ($service === 'home') {
        $services = $_POST['services'] ?? [];
        $service_cycle = $_POST['service_cycle'] ?? '';
        $from_date = $_POST['from'] ?? '';
        $to_date = $_POST['to'] ?? '';
        $time = $_POST['appointment_time'] ?? '';

        if (empty($services)) {
            echo json_encode(['success' => false, 'message' => 'Enter Sevices']);
            exit;
        }
        if ($service_cycle == '') {
            echo json_encode(['success' => false, 'message' => 'Select Service Cycle']);
            exit;
        }
        if ($from_date == '') {
            echo json_encode(['success' => false, 'message' => 'Enter From Date']);
            exit;
        }
        if ($to_date == '') {
            echo json_encode(['success' => false, 'message' => 'Enter To Date']);
            exit;
        }
        if (strtotime($from_date) > strtotime($to_date)) {
            echo json_encode(['success' => false, 'message' => 'From date cannot be greater than To date']);
            exit;
        }
        if ($time == '') {
            echo json_encode(['success' => false, 'message' => 'Enter Time']);
            exit;
        }
    }
    $purpose = trim($_POST['purpose'] ?? '');
    $patient = $conn->prepare("INSERT INTO tbl_patient(name,mobile,email,age,gender,address,created_at,updated_at)VALUES(?,?,?,?,?,?,NOW(),NOW())");
    $patient->bind_param('sssiss',$name,$mobile,$email,$age,$gender,$address);
} catch (\Throwable $th) {
    echo json_encode(['success' => false, 'message' => "Error" . $th->getMessage()]);
    exit;
}


ob_end_flush();
