<?php
    $page = basename($_SERVER['PHP_SELF'], '.php');
    $titles = [
        'index' => 'Home Page',
        'appointment-list' => 'Appointment List',
        'book-appointment' => 'Book Appointment',
        'profile' => 'Profile',
        'add-staff' => 'Add Staff',
        'staff-list' => 'Staff List',
        'doctor-wise-schedule' => 'Doctor Wise Schedule',
        'appointment-reschedule-cancel' => 'Reschedule or Cancel Appointment',
        'online-appointment' => 'Online Appointment',
        'attendance' => 'Staff Attendance',
        'leave-management' => 'Leave Management',
        'staff_payroll' => 'Staff Payroll',
        'roles-and-permission' => 'Roles and Permission',
        'add-doctor' => 'Add Doctor',
        'doctor-list' => 'Doctor List'
    ];

    $title = isset($titles[$page]) ? $titles[$page] : 'Home Page';
?>