<?php
    $page = basename($_SERVER['PHP_SELF'], '.php');
    $titles = [
        'index' => 'Home Page',
        'appointment-list' => 'Appointment List',
        'book-appointment' => 'Book Appointment',
        'profile' => 'Profile',
        'add-staff' => 'Add Staff',
        'staff-list' => 'Staff List',
        'doctor-wise-schedule' => 'Doctor Wise Schedule'
    ];

    $title = isset($titles[$page]) ? $titles[$page] : 'Home Page';
?>