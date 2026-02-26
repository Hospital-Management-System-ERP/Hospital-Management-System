<?php
ob_start();
date_default_timezone_set('Asia/Kolkata');
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include __DIR__ . '/../../config.php';
header("Content-Type: application/json");

try {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        echo json_encode(['success' => false, 'status' => 'error', 'message' => 'Only POST Method allowed']);
        exit;
    }
    if (
        !isset($_POST['csrf_token'], $_SESSION['csrf_token']) ||
        !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])
    ) {
        echo json_encode([
            'success' => false,
            'message' => 'Invalid CSRF token',
            'session_token' => $_SESSION['csrf_token'] ?? null,
            'post_token' => $_POST['csrf_token'] ?? null,
            'session_id' => session_id()
        ]);
        exit;
    }
    function generateEmpId($conn, $digit = 4)
    {
        $year = date('Y');
        do {
            $randomNumber = mt_rand(pow(10, $digit - 1), pow(10, $digit) - 1);
            $emp_id = "EMP{$year}{$randomNumber}";
            $stmt1 = $conn->prepare("SELECT COUNT(*) as count FROM tbl_staff WHERE emp_id = ?");
            $stmt1->bind_param("s", $emp_id);
            $stmt1->execute();
            $result1 = $stmt1->get_result()->fetch_assoc();
            $stmt1->close();

            $stmt2 = $conn->prepare("SELECT COUNT(*) as count FROM tbl_doctor WHERE emp_id = ?");
            $stmt2->bind_param("s", $emp_id);
            $stmt2->execute();
            $result2 = $stmt2->get_result()->fetch_assoc();
            $stmt2->close();
        } while ($result1['count'] > 0 || $result2['count'] > 0);
        return $emp_id;
    }
    $conn->begin_transaction();
    $emp_id = generateEmpId($conn);
    $first_name = trim($_POST['first_name'] ?? '');
    $lname = trim($_POST['last_name'] ?? '');
    $fullname = $first_name . ' ' . $lname;
    $fname = trim($_POST['fname'] ?? '');
    $mname = trim($_POST['mname'] ?? '');
    $mobile = trim($_POST['mobile'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $dob = trim($_POST['dob'] ?? '');
    $gender = trim($_POST['gender'] ?? '');
    $religion = trim($_POST['religion'] ?? '');
    $bgroup = trim($_POST['bgroup'] ?? '');
    $marital_status = trim($_POST['marital_status'] ?? '');
    $nationality = trim($_POST['nationality'] ?? '');

    $full_address = trim($_POST['full_address'] ?? '');
    $post = trim($_POST['post'] ?? '');
    $police = trim($_POST['police'] ?? '');
    $dist = trim($_POST['dist'] ?? '');
    $state = trim($_POST['state'] ?? '');
    $pincode = trim($_POST['pincode'] ?? '');

    $p_full_address = trim($_POST['p_full_address'] ?? '');
    $p_post = trim($_POST['p_post'] ?? '');
    $p_police = trim($_POST['p_police'] ?? '');
    $p_dist = trim($_POST['p_dist'] ?? '');
    $p_state = trim($_POST['p_state'] ?? '');
    $p_pincode = trim($_POST['p_pincode'] ?? '');

    $parmanent_address = implode(', ', array_filter([
        $full_address,
        $post,
        $police,
        $dist,
        $state
    ])) . ($pincode ? ' - ' . $pincode : '');

    $present_address = implode(', ', array_filter([
        $p_full_address,
        $p_post,
        $p_police,
        $p_dist,
        $p_state
    ])) . ($p_pincode ? ' - ' . $p_pincode : '');
    $role = trim($_POST['role'] ?? '');
    $emp_type = trim($_POST['emp_type'] ?? '');
    $date_of_joining = trim($_POST['date_of_joining'] ?? '');
    $bank = trim($_POST['bank'] ?? '');
    $pay_cycle = trim($_POST['pay_cycle'] ?? '');
    $basicSalary = trim($_POST['salary'] ?? '');
    $salaryNames   = $_POST['salary_name'] ?? [];
    $salaryAmounts = $_POST['salary_amount'] ?? [];
    $salaryParts = [];
    if (!empty($basicSalary)) {
        $salaryParts[] = "Basic " . $basicSalary;
    }
    for ($i = 0; $i < count($salaryNames); $i++) {
        $name   = trim($salaryNames[$i] ?? '');
        $amount = trim($salaryAmounts[$i] ?? '');
        if (!empty($name) && !empty($amount)) {
            $salaryParts[] = $name . " " . $amount;
        }
    }
    $finalSalaryString = implode(", ", $salaryParts);

    // file uploading 
    function uploadFiles($inputname, $folder)
    {
        if (!isset($_FILES[$inputname]) || $_FILES[$inputname]['error'] == UPLOAD_ERR_NO_FILE) {
            return null;
        }
        $allowed = ['jpg', 'jpeg', 'png', 'pdf'];
        $maxSize = 2 * 1024 * 1024;

        $fileName = $_FILES[$inputname]['name'];
        $fileTmp  = $_FILES[$inputname]['tmp_name'];
        $fileSize = $_FILES[$inputname]['size'];

        $ext = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        if (!in_array($ext, $allowed)) {
            echo json_encode(['success' => false, 'status' => 'error', 'message' => 'file type not allowed']);
            return;
        }
        if ($fileSize > $maxSize) {
            echo json_encode(['success' => false, 'status' => 'error', 'message' => 'File size should be less than 2 MB']);
            return;
        }
        if (!is_dir($folder)) {
            mkdir($folder, 0755, true);
        }
        $newName = uniqid($inputname . "_") . "." . $ext;
        $destination = rtrim($folder, '/') . '/' . $newName;
        if (!move_uploaded_file($fileTmp, $destination)) {
            echo json_encode(['success' => false, 'status' => 'error', 'message' => 'File type not allowed']);
            return;
        }
        return $newName;
    }
    $documentFolder =  __DIR__ . "/../../staff/documents";
    $imageFolder    = __DIR__ . "/../../staff/images/";
    $adhar            = uploadFiles('adhar', $documentFolder);
    $certificate      = uploadFiles('certificate', $documentFolder);
    $experienceLetter = uploadFiles('experience_letter', $documentFolder);
    $image = uploadFiles('image', $imageFolder);

    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if (empty($password)) {
        echo json_encode(['success' => false, 'status' => 'error', 'message' => 'Password Required']);
        return;
    }
    if (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&]).{6,}$/', $password)) {
        echo json_encode([
            'success' => false,
            'message' => 'Password must contain uppercase, lowercase, number and special character (min 6 characters)'
        ]);
        exit;
    }
    $password = password_hash($password, PASSWORD_DEFAULT);
    $access = array_map('intval', $_POST['access'] ?? []);
    $status = 1;

    $checkAdmin = $conn->prepare("SELECT id FROM admin WHERE username = ?");
    $checkAdmin->bind_param("s", $username);
    $checkAdmin->execute();
    $checkAdmin->store_result();
    if ($checkAdmin->num_rows > 0) {
        echo json_encode([
            'success' => false,
            'status' => 'error',
            'message' => 'Username already exists (Admin)'
        ]);
        exit;
    }
    $checkStaff = $conn->prepare("SELECT id FROM tbl_staff WHERE username = ?");
    $checkStaff->bind_param("s", $username);
    $checkStaff->execute();
    $checkStaff->store_result();

    if ($checkStaff->num_rows > 0) {
        echo json_encode([
            'success' => false,
            'status' => 'error',
            'message' => 'Username already exists (Staff)'
        ]);
        exit;
    }
    $checkDoctor = $conn->prepare("SELECT id FROM tbl_doctor WHERE username = ?");
    $checkDoctor->bind_param("s", $username);
    $checkDoctor->execute();
    $checkDoctor->store_result();

    if ($checkDoctor->num_rows > 0) {
        echo json_encode([
            'success' => false,
            'status' => 'error',
            'message' => 'Username already exists (Doctor)'
        ]);
        exit;
    }
    if ($role === 'admin') {
        $admin = $conn->prepare("INSERT INTO admin (name, mobile, username, password, role, status, created_at, updated_at)VALUES (?, ?, ?, ?, ?, ?, NOW(), NOW())");
        $admin->bind_param('sssssi', $fullname, $mobile, $username, $password, $role, $status);
        if (!$admin->execute()) {
            echo json_encode([
                'success' => false,
                'status' => 'error',
                'message' => $admin->error
            ]);
            return;
        }
    } else {
        $staff = $conn->prepare("
            INSERT INTO tbl_staff(
                emp_id,
                name,
                fname,
                mname,
                mobile,
                email,
                dob,
                gender,
                religion,
                blood_group,
                marital_status,
                nationality,
                permanent_address,
                present_address,
                role,
                employee_type,
                date_of_joining,
                salary,
                bank,
                pay_cycle,
                adhar,
                certificate,
                experience_letter,
                image,
                username,
                password,
                status,
                created_at,
                updated_at
            )VALUES(
                ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), NOW()
            )
        ");
        $staff->bind_param(
            'ssssssssssssssssssssssssssi',
            $emp_id,
            $fullname,
            $fname,
            $mname,
            $mobile,
            $email,
            $dob,
            $gender,
            $religion,
            $bgroup,
            $marital_status,
            $nationality,
            $parmanent_address,
            $present_address,
            $role,
            $emp_type,
            $date_of_joining,
            $finalSalaryString,
            $bank,
            $pay_cycle,
            $adhar,
            $certificate,
            $experienceLetter,
            $image,
            $username,
            $password,
            $status
        );
        if (!$staff->execute()) {
            echo json_encode([
                'success' => false,
                'status' => 'error',
                'message' => $staff->error
            ]);
            return;
        }
        $staff_id = $emp_id;
    }

    if ($role !== 'admin' && !empty($access)) {

        $stmt = $conn->prepare("
        INSERT INTO staff_permissions(staff_id, permission_id)
        VALUES (?, ?)
    ");
        foreach ($access as $permission_id) {
            $stmt->bind_param("si", $staff_id, $permission_id);
            if (!$stmt->execute()) {
                echo json_encode(['success' => false, 'message' => $stmt->error]);
                return;
            }
        }
    }

    $conn->commit();
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    echo json_encode([
        'success' => true,
        'status' => 'success',
        'message' => $role === 'admin'
            ? 'Admin added successfully'
            : 'Staff added successfully'
    ]);
    return;
} catch (Exception $e) {
    $conn->rollback();
    echo json_encode([
        'success' => false,
        'status' => 'error',
        'message' => 'error' . $e->getMessage()
    ]);
    return;
}

ob_end_flush();
