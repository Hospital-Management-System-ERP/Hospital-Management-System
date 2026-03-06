<?php
ob_start();
date_default_timezone_set('Asia/Kolkata');

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include __DIR__ . '/../../config.php';
$doctors = [];

if (isset($_GET['specialization_id']) && $_GET['specialization_id'] != '') {
    $specialization_id = $_GET['specialization_id'];
    $fetch = $conn->prepare("SELECT d.id, d.name FROM tbl_doctor d JOIN tbl_doctor_specialization_map ds ON d.emp_id = ds.doctor_id WHERE ds.specialization_id = ?");
    $fetch->bind_param('i', $specialization_id);
    $fetch->execute();
    $result = $fetch->get_result();
    while ($row = $result->fetch_assoc()) {
        $doctors[] = $row;
    }
}
echo json_encode($doctors);

ob_end_flush();
