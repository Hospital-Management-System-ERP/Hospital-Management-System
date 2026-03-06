<?php
ob_start();
date_default_timezone_set('Asia/Kolkata');
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include __DIR__ . '/../../config.php';
header("Content-Type: application/json");

try {
    if ($_SERVER['REQUEST_METHOD'] != 'POST') {
        echo json_encode(['success' => false, 'message' => 'Only Post Method Allowed']);
        exit;
    }

    if (!isset($_SESSION['csrf_token']) || $_POST['csrf_token'] != $_SESSION['csrf_token']) {
        echo json_encode(['success' => false, 'message' => 'Invalid Token']);
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
    $name = trim($_POST['name'] ?? '');
    $fname = trim($_POST['fname'] ?? '');
    $mobile = trim($_POST['mobile'] ?? '');
    $mobile = preg_replace('/\D/', '', $mobile);
    $email = trim($_POST['email'] ?? '');
    $email = filter_var($email, FILTER_SANITIZE_EMAIL);
    $dob = trim($_POST['dob'] ?? '');
    $gender = trim($_POST['gender'] ?? '');
    $religion = trim($_POST['religion'] ?? '');
    $adhar_no = trim($_POST['adhar'] ?? '');
    $adhar_no = str_replace(' ', '', $adhar_no);
    $adhar_no = preg_replace('/\D/', '', $adhar_no);
    $bgroup = trim($_POST['bgroup'] ?? '');
    $nationality = trim($_POST['nationality'] ?? '');
    $marital_status = trim($_POST['marital_status'] ?? '');
    $qualification = trim($_POST['qualification'] ?? '');
    $council = trim($_POST['council'] ?? '');
    $experience = trim($_POST['experience'] ?? '');
    $department = trim($_POST['department'] ?? '');
    $consult_fee = trim($_POST['consult_fee'] ?? '');
    $available_day = trim($_POST['available_day'] ?? '');
    $from_time = trim($_POST['from_time'] ?? '');
    $to_time = trim($_POST['to_time'] ?? '');
    $time_slot = '';
    if ($from_time != '' && $to_time != '') {
        $from_time_formatted = date("h:i A", strtotime($from_time));
        $to_time_formatted   = date("h:i A", strtotime($to_time));

        $time_slot = $from_time_formatted . ' - ' . $to_time_formatted;
    }
    $specializations = $_POST['specialization'] ?? [];
    $specializations = array_map('intval', $specializations);
    // isko foreach se bhejna hoga 

    $permanent_address = $_POST['permanent_address'] ?? '';
    $present_address = $_POST['present_address'] ?? '';
    $role = trim($_POST['role'] ?? '');
    $emp_type = trim($_POST['emp_type'] ?? '');
    $date_of_joining = trim($_POST['date_of_joining'] ?? '');
    $pay_cycle = $_POST['pay_cycle'] ?? '';
    $bank = trim($_POST['bank'] ?? '');
    $account = trim($_POST['account'] ?? '');
    $ifsc_code = strtoupper(trim($_POST['ifsc_code'] ?? ''));
    $basicSalary = trim($_POST['salary'] ?? '');

    $salary_name = $_POST['salary_name'] ?? [];
    $salary_amount = $_POST['salary_amount'] ?? [];
    $salaryParts = [];
    if (!empty($basicSalary)) {
        $salaryParts[] = "Basic " . $basicSalary;
    }
    $count = min(count($salary_name), count($salary_amount));
    for ($i = 0; $i < $count; $i++) {
        $salname = trim($salary_name[$i] ?? '');
        $amount = trim($salary_amount[$i] ?? '');
        if (!empty($salname) && !empty($amount)) {
            $salaryParts[] = $salname . " " . $amount;
        }
    }
    $finalSalary = implode(", ", $salaryParts);

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
            exit;
        }
        if ($fileSize > $maxSize) {
            echo json_encode(['success' => false, 'status' => 'error', 'message' => 'File size should be less than 2 MB']);
            exit;
        }
        if (!is_dir($folder)) {
            mkdir($folder, 0755, true);
        }
        $newName = uniqid($inputname . "_") . "." . $ext;
        $destination = rtrim($folder, '/') . '/' . $newName;
        if (!move_uploaded_file($fileTmp, $destination)) {
            echo json_encode(['success' => false, 'status' => 'error', 'message' => 'File type not allowed']);
            exit;
        }
        return $newName;
    }
    $documentFolder =  __DIR__ . "/../../doctor/documents/";
    $imageFolder    = __DIR__ . "/../../doctor/images/";
    $adhar            = uploadFiles('adharcard', $documentFolder);
    $certificate      = uploadFiles('certificate', $documentFolder);
    $experienceLetter = uploadFiles('experience_letter', $documentFolder);
    $image = uploadFiles('photo', $imageFolder);

    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');
    $cnf_password = trim($_POST['cnf_password'] ?? '');

    // validation here
    if ($name == '') {
        echo json_encode(['success' => false, 'message' => 'Name is requied']);
        exit;
    }
    if ($fname == '') {
        echo json_encode(['success' => false, 'message' => 'Father name is required']);
        exit;
    }
    if ($mobile == '') {
        echo json_encode(['success' => false, 'message' => 'Enter Mobile No']);
        exit;
    }
    if (!preg_match('/^[0-9]{10}$/', $mobile)) {
        echo json_encode(['success' => false, 'message' => 'Enter a valid 10-digit mobile number']);
        exit;
    }
    if ($email != '' && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(['success' => false, 'message' => 'Enter valid email']);
        exit;
    }
    if ($dob == '') {
        echo json_encode(['success' => false, 'message' => 'Enter Date of Birth']);
        exit;
    }
    if ($gender == '') {
        echo json_encode(['success' => false, 'message' => 'Select Gender']);
        exit;
    }
    if ($religion == '') {
        echo json_encode(['success' => false, 'message' => 'Select Religion']);
        exit;
    }
    if ($adhar_no == '') {
        echo json_encode(['success' => false, 'message' => 'Enter Adhar No']);
        exit;
    }
    if (!preg_match('/^[0-9]{12}$/', $adhar_no)) {
        echo json_encode(['success' => false, 'message' => 'Enter 12 Digit Adhar Number']);
        exit;
    }
    if ($nationality == '') {
        echo json_encode(['success' => false, 'message' => 'Select Nationality']);
        exit;
    }
    if ($marital_status == '') {
        echo json_encode(['success' => false, 'message' => 'Select Marital Status']);
        exit;
    }
    if ($qualification == '') {
        echo json_encode(['success' => false, 'message' => 'Enter Qualification']);
        exit;
    }
    if ($experience == '') {
        echo json_encode(['success' => false, 'message' => 'Enter Experience']);
        exit;
    }
    if ($department == '') {
        echo json_encode(['success' => false, 'message' => 'Select Department']);
        exit;
    }
    if ($consult_fee == '') {
        echo json_encode(['success' => false, 'message' => 'Enter Consult Fee']);
        exit;
    }
    if (!is_numeric($consult_fee)) {
        echo json_encode(['success' => false, 'message' => 'Consult Fee must be numeric']);
        exit;
    }
    if ($available_day == '') {
        echo json_encode(['success' => false, 'message' => 'Select Available Day']);
        exit;
    }
    if ($from_time == '' || $to_time == '') {
        echo json_encode(['success' => false, 'message' => 'Select Time']);
        exit;
    }
    if (strtotime($from_time) >= strtotime($to_time)) {
        echo json_encode(['success' => false, 'message' => 'From Time must be less than To Time']);
        exit;
    }
    if (empty($specializations) || count($specializations) == 0) {
        echo json_encode(['success' => false, 'message' => 'Check specialization']);
        exit;
    }
    if ($permanent_address == '' || $present_address == '') {
        echo json_encode(['success' => false, 'message' => 'Enter Parmanent & Present Address']);
        exit;
    }
    if ($role == '') {
        echo json_encode(['success' => false, 'message' => 'Enter Role']);
        exit;
    }
    if ($emp_type == '') {
        echo json_encode(['success' => false, 'message' => 'Select Employee type']);
        exit;
    }
    if ($date_of_joining == '') {
        echo json_encode(['success' => false, 'message' => 'Enter Date of Joining']);
        exit;
    }
    if ($account != '' && !preg_match('/^[0-9]{9,18}$/', $account)) {
        echo json_encode(['success' => false, 'message' => 'Enter valid Account Number']);
        exit;
    }
    if ($ifsc_code != '' && !preg_match('/^[A-Z]{4}0[A-Z0-9]{6}$/', $ifsc_code)) {
        echo json_encode(['success' => false, 'message' => 'Enter valid IFSC Code']);
        exit;
    }
    if ($basicSalary == '') {
        echo json_encode(['success' => false, 'message' => 'Enter Salary']);
        exit;
    }
    if (!is_numeric($basicSalary)) {
        echo json_encode(['success' => false, 'message' => 'Salary must be numeric']);
        exit;
    }
    if ($username == '') {
        echo json_encode(['success' => false, 'message' => 'Enter Username']);
        exit;
    }
    if ($password == '') {
        echo json_encode(['success' => false, 'message' => 'Enter Password']);
        exit;
    }
    if (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&]).{6,}$/', $password)) {
        echo json_encode([
            'success' => false,
            'message' => 'Password must contain uppercase, lowercase, number and special character (min 6 characters)'
        ]);
        exit;
    }
    if ($password !== $cnf_password) {
        echo json_encode([
            'success' => false,
            'message' => 'Password and Confirm Password do not match'
        ]);
        exit;
    }

    $password = password_hash($password, PASSWORD_DEFAULT);
    $access = array_map('intval', $_POST['access'] ?? []);
    $status = 1;

    // check exits
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

    $doctor = $conn->prepare("
        INSERT INTO tbl_doctor(
            emp_id,
            name,
            fname,
            mobile,
            email,
            dob,
            gender,
            religion,
            adhar_no,
            blood_group,
            marital_status,
            nationality,
            qualification,
            council_no,
            experience,
            department,
            fees,
            available_day,
            available_time,
            parmanent_address,
            present_address,
            role,
            emp_type,
            date_of_joining,
            bank_name,
            account,
            ifsc,
            pay_cycle,
            salary,
            adhar,
            certificate,
            experience_letter,
            image,
            username,
            password,
            status,
            created_at,
            updated_at
        )VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,NOW(), NOW())
    ");
    $types = str_repeat('s', 35) . 'i';
    $doctor->bind_param(
        $types,
        $emp_id,
        $name,
        $fname,
        $mobile,
        $email,
        $dob,
        $gender,
        $religion,
        $adhar_no,
        $bgroup,
        $marital_status,
        $nationality,
        $qualification,
        $council,
        $experience,
        $department,
        $consult_fee,
        $available_day,
        $time_slot,
        $permanent_address,
        $present_address,
        $role,
        $emp_type,
        $date_of_joining,
        $bank,
        $account,
        $ifsc_code,
        $pay_cycle,
        $finalSalary,
        $adhar,
        $certificate,
        $experienceLetter,
        $image,
        $username,
        $password,
        $status
    );
    if (!$doctor->execute()) {
        echo json_encode([
            'success' => false,
            'status' => 'error',
            'message' => $doctor->error
        ]);
        exit;
    }
    $doctor_id = $emp_id;
    if (!empty($access)) {
        $stmt = $conn->prepare("
        INSERT INTO staff_permissions(staff_id, permission_id)
        VALUES (?, ?)
    ");
        foreach ($access as $permission_id) {
            $stmt->bind_param("si", $doctor_id, $permission_id);
            if (!$stmt->execute()) {
                echo json_encode(['success' => false, 'message' => $stmt->error]);
                exit;
            }
        }
    }

    if (!empty($specializations)) {
        $drSpecialisation = $conn->prepare("INSERT INTO tbl_doctor_specialization_map(doctor_id,specialization_id,created_at,updated_at)VALUES(?,?,NOW(),NOW())");
        foreach ($specializations as $specializations_id) {
            $drSpecialisation->bind_param('si', $doctor_id, $specializations_id);
            if (!$drSpecialisation->execute()) {
                echo json_encode(['success' => false, 'message' => $drSpecialisation->error]);
                exit;
            }
        }
    }
    $conn->commit();
    echo json_encode([
        'success' => true,
        'status' => 'success',
        'message' => 'Doctor added successfully'
    ]);
} catch (\Throwable $th) {
    $conn->rollback();
    echo json_encode(['success' => false, 'message' => 'Error: ' . $th->getMessage()]);
    exit;
}
ob_end_flush();
