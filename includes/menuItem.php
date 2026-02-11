<?php
$sidebarItems = [
    ['title' => 'Dashboard', 'icon' => 'bi-grid-fill', 'url' => BASE_URL, 'permission' => null],
    // Patient
    ['title' => 'Add New Patient', 'icon' => 'bi-people', 'url' => '', 'permission' => 'patient_add', 'parent' => 'Patients'],
    ['title' => 'Patient List', 'icon' => 'bi-people', 'url' => '', 'permission' => 'patient_list', 'parent' => 'Patients'],
    ['title' => 'OPD Patient', 'icon' => 'bi-people', 'url' => '', 'permission' => 'patient_opd', 'parent' => 'Patients'],
    ['title' => 'IPD Patients', 'icon' => 'bi-people', 'url' => '', 'permission' => 'patient_ipd', 'parent' => 'Patients'],
    ['title' => 'Patient Documents', 'icon' => 'bi-people', 'url' => '', 'permission' => 'patient_documents', 'parent' => 'Patients'],
    ['title' => 'Patient History', 'icon' => 'bi-people', 'url' => '', 'permission' => 'patient_history', 'parent' => 'Patients'],
    ['title' => 'Discharge Summary', 'icon' => 'bi-people', 'url' => '', 'permission' => 'patient_discharge', 'parent' => 'Patients'],

    // Appointments
    ['title' => 'Book Appointment', 'icon' => 'bi-calendar-check', 'url' => BASE_URL.'appointment/book-appointment', 'permission' => 'appointment_book', 'parent' => 'Appointment'],
    ['title' => 'Appointment List', 'icon' => 'bi-calendar-check', 'url' => BASE_URL.'appointment/appointment-list', 'permission' => 'appointment_list', 'parent' => 'Appointment'],
    ['title' => 'Doctor-wise Schedule', 'icon' => 'bi-calendar-check', 'url' => BASE_URL.'appointment/doctor-wise-schedule', 'permission' => 'appointment_schedule', 'parent' => 'Appointment'],
    ['title' => 'Reschedule / Cancel', 'icon' => 'bi-calendar-check', 'url' => BASE_URL.'appointment/appointment-reschedule-cancel', 'permission' => 'appointment_reschedule_cancel', 'parent' => 'Appointment'],
    ['title' => 'Online Appointments', 'icon' => 'bi-calendar-check', 'url' => BASE_URL.'appointment/online-appointment', 'permission' => 'appointment_online', 'parent' => 'Appointment'],

    // doctor management
    ['title' => 'Add Doctor', 'icon' => 'bi-person-badge', 'url' => '', 'permission' => 'doctor_add', 'parent' => 'Doctor Management'],
    ['title' => 'Doctor List', 'icon' => 'bi-person-badge', 'url' => '', 'permission' => 'doctor_list', 'parent' => 'Doctor Management'],
    ['title' => 'Doctor Schedule', 'icon' => 'bi-person-badge', 'url' => '', 'permission' => 'doctor_schedule', 'parent' => 'Doctor Management'],
    ['title' => 'Specialization', 'icon' => 'bi-person-badge', 'url' => '', 'permission' => 'doctor_specialization', 'parent' => 'Doctor Management'],
    ['title' => 'Consultation Charges', 'icon' => 'bi-person-badge', 'url' => '', 'permission' => 'doctor_charges', 'parent' => 'Doctor Management'],

    // OPD / IPD
    ['title' => 'OPD Registration', 'icon' => 'bi-hospital', 'url' => '', 'permission' => 'opd_registration', 'parent' => 'OPD / IPD'],
    ['title' => 'IPD Admission', 'icon' => 'bi-hospital', 'url' => '', 'permission' => 'ipd_admission', 'parent' => 'OPD / IPD'],
    ['title' => 'Bed Allocation', 'icon' => 'bi-hospital', 'url' => '', 'permission' => 'bed_allocation', 'parent' => 'OPD / IPD'],
    ['title' => 'Ward Management', 'icon' => 'bi-hospital', 'url' => '', 'permission' => 'ward_management', 'parent' => 'OPD / IPD'],
    ['title' => 'Room Transfer', 'icon' => 'bi-hospital', 'url' => '', 'permission' => 'room_transfer', 'parent' => 'OPD / IPD'],
    ['title' => 'Discharge Process', 'icon' => 'bi-hospital', 'url' => '', 'permission' => 'discharge_process', 'parent' => 'OPD / IPD'],

    // Billing & Payments
    ['title' => 'Generate Bill', 'icon' => 'bi-wallet2', 'url' => '', 'permission' => 'billing_generate', 'parent' => 'Billing & Payments'],
    ['title' => 'OPD Billing', 'icon' => 'bi-wallet2', 'url' => '', 'permission' => 'billing_opd', 'parent' => 'Billing & Payments'],
    ['title' => 'Insurance Billing', 'icon' => 'bi-wallet2', 'url' => '', 'permission' => 'billing_insurance', 'parent' => 'Billing & Payments'],
    ['title' => 'Payment History', 'icon' => 'bi-wallet2', 'url' => '', 'permission' => 'billing_history', 'parent' => 'Billing & Payments'],
    ['title' => 'Tax Reports', 'icon' => 'bi-wallet2', 'url' => '', 'permission' => 'billing_tax', 'parent' => 'Billing & Payments'],

    // Laboratory
    ['title' => 'Lab Test Categories', 'icon' => 'bi-droplet-half', 'url' => '', 'permission' => 'lab_categories', 'parent' => 'Laboratory'],
    ['title' => 'Add Test', 'icon' => 'bi-droplet-half', 'url' => '', 'permission' => 'lab_add_test', 'parent' => 'Laboratory'],
    ['title' => 'Test Request', 'icon' => 'bi-droplet-half', 'url' => '', 'permission' => 'lab_test_request', 'parent' => 'Laboratory'],
    ['title' => 'Sample Collection', 'icon' => 'bi-droplet-half', 'url' => '', 'permission' => 'lab_sample_collection', 'parent' => 'Laboratory'],
    ['title' => 'Test Reports', 'icon' => 'bi-droplet-half', 'url' => '', 'permission' => 'lab_test_reports', 'parent' => 'Laboratory'],
    ['title' => 'Report Printing', 'icon' => 'bi-droplet-half', 'url' => '', 'permission' => 'lab_report_printing', 'parent' => 'Laboratory'],

    // Radiology
    ['title' => 'X-Ray', 'icon' => 'bi-radioactive', 'url' => '', 'permission' => 'radiology_xray', 'parent' => 'Radiology'],
    ['title' => 'MRI', 'icon' => 'bi-radioactive', 'url' => '', 'permission' => 'radiology_mri', 'parent' => 'Radiology'],
    ['title' => 'CT Scan', 'icon' => 'bi-radioactive', 'url' => '', 'permission' => 'radiology_ct', 'parent' => 'Radiology'],
    ['title' => 'Ultrasound', 'icon' => 'bi-radioactive', 'url' => '', 'permission' => 'radiology_ultrasound', 'parent' => 'Radiology'],
    ['title' => 'Radiology Reports', 'icon' => 'bi-radioactive', 'url' => '', 'permission' => 'radiology_reports', 'parent' => 'Radiology'],

    // Pharmacy
    ['title' => 'Add Medicine', 'icon' => 'bi-capsule', 'url' => '', 'permission' => 'pharmacy_add_medicine', 'parent' => 'Pharmacy'],
    ['title' => 'Stock Management', 'icon' => 'bi-capsule', 'url' => '', 'permission' => 'pharmacy_stock', 'parent' => 'Pharmacy'],
    ['title' => 'Purchase Entry', 'icon' => 'bi-capsule', 'url' => '', 'permission' => 'pharmacy_purchase', 'parent' => 'Pharmacy'],
    ['title' => 'Sale / Issue Medicine', 'icon' => 'bi-capsule', 'url' => '', 'permission' => 'pharmacy_sale', 'parent' => 'Pharmacy'],
    ['title' => 'Expiry Tracking', 'icon' => 'bi-capsule', 'url' => '', 'permission' => 'pharmacy_expiry', 'parent' => 'Pharmacy'],
    ['title' => 'Supplier Management', 'icon' => 'bi-capsule', 'url' => '', 'permission' => 'pharmacy_supplier', 'parent' => 'Pharmacy'],

    // Operation Theatre
    ['title' => 'OT Schedule', 'icon' => 'bi-scissors', 'url' => '', 'permission' => 'ot_schedule', 'parent' => 'Operation Theatre'],
    ['title' => 'Surgery List', 'icon' => 'bi-scissors', 'url' => '', 'permission' => 'ot_surgery_list', 'parent' => 'Operation Theatre'],
    ['title' => 'Surgeon Assignment', 'icon' => 'bi-scissors', 'url' => '', 'permission' => 'ot_surgeon_assignment', 'parent' => 'Operation Theatre'],
    ['title' => 'Pre / Post Operation Notes', 'icon' => 'bi-scissors', 'url' => '', 'permission' => 'ot_notes', 'parent' => 'Operation Theatre'],

    // Ambulance
    ['title' => 'Add Ambulance', 'icon' => 'bi-truck-front', 'url' => '', 'permission' => 'ambulance_add', 'parent' => 'Ambulance'],
    ['title' => 'Ambulance List', 'icon' => 'bi-truck-front', 'url' => '', 'permission' => 'ambulance_list', 'parent' => 'Ambulance'],
    ['title' => 'Driver Management', 'icon' => 'bi-truck-front', 'url' => '', 'permission' => 'ambulance_driver', 'parent' => 'Ambulance'],
    ['title' => 'Ambulance Requests', 'icon' => 'bi-truck-front', 'url' => '', 'permission' => 'ambulance_requests', 'parent' => 'Ambulance'],
    ['title' => 'Trip History', 'icon' => 'bi-truck-front', 'url' => '', 'permission' => 'ambulance_trip', 'parent' => 'Ambulance'],

    // Nurse Station
    ['title' => 'Patient Vitals', 'icon' => 'bi-heart-pulse', 'url' => '', 'permission' => 'nurse_vitals', 'parent' => 'Nurse Station'],
    ['title' => 'Medication Schedule', 'icon' => 'bi-heart-pulse', 'url' => '', 'permission' => 'nurse_medication', 'parent' => 'Nurse Station'],
    ['title' => 'Nursing Notes', 'icon' => 'bi-heart-pulse', 'url' => '', 'permission' => 'nurse_notes', 'parent' => 'Nurse Station'],
    ['title' => 'Shift Management', 'icon' => 'bi-heart-pulse', 'url' => '', 'permission' => 'nurse_shift', 'parent' => 'Nurse Station'],

    // Staff / HR
    ['title' => 'Add Staff', 'icon' => 'bi-people-fill', 'url' => BASE_URL.'staff/add-staff', 'permission' => 'staff_add', 'parent' => 'Staff'],
    ['title' => 'Staff List', 'icon' => 'bi-people-fill', 'url' => BASE_URL.'staff/staff-list', 'permission' => 'staff_list', 'parent' => 'Staff'],
    ['title' => 'Attendance', 'icon' => 'bi-people-fill', 'url' => '', 'permission' => 'staff_attendance', 'parent' => 'Staff'],
    ['title' => 'Leave Management', 'icon' => 'bi-people-fill', 'url' => '', 'permission' => 'staff_leave', 'parent' => 'Staff'],
    ['title' => 'Payroll', 'icon' => 'bi-people-fill', 'url' => '', 'permission' => 'staff_payroll', 'parent' => 'Staff'],
    ['title' => 'Roles & Permissions', 'icon' => 'bi-people-fill', 'url' => '', 'permission' => 'staff_roles_permissions', 'parent' => 'Staff'],

    // Inventory
    ['title' => 'Medical Equipment', 'icon' => 'bi-box-seam', 'url' => '', 'permission' => 'inventory_equipment', 'parent' => 'Inventory'],
    ['title' => 'Consumables', 'icon' => 'bi-box-seam', 'url' => '', 'permission' => 'inventory_consumables', 'parent' => 'Inventory'],
    ['title' => 'Stock In / Out', 'icon' => 'bi-box-seam', 'url' => '', 'permission' => 'inventory_stock', 'parent' => 'Inventory'],
    ['title' => 'Low Stock Alert', 'icon' => 'bi-box-seam', 'url' => '', 'permission' => 'inventory_low_stock', 'parent' => 'Inventory'],

    // Reports
    ['title' => 'Daily / Monthly Reports', 'icon' => 'bi-bar-chart-line', 'url' => '', 'permission' => 'report_daily_monthly', 'parent' => 'Reports'],
    ['title' => 'Patient Reports', 'icon' => 'bi-bar-chart-line', 'url' => '', 'permission' => 'report_patient', 'parent' => 'Reports'],
    ['title' => 'Revenue Reports', 'icon' => 'bi-bar-chart-line', 'url' => '', 'permission' => 'report_revenue', 'parent' => 'Reports'],
    ['title' => 'Doctor Reports', 'icon' => 'bi-bar-chart-line', 'url' => '', 'permission' => 'report_doctor', 'parent' => 'Reports'],
    ['title' => 'Pharmacy Reports', 'icon' => 'bi-bar-chart-line', 'url' => '', 'permission' => 'report_pharmacy', 'parent' => 'Reports'],
    ['title' => 'Lab Reports', 'icon' => 'bi-bar-chart-line', 'url' => '', 'permission' => 'report_lab', 'parent' => 'Reports'],

    // Accounts
    ['title' => 'Income', 'icon' => 'bi-currency-rupee', 'url' => '', 'permission' => 'accounts_income', 'parent' => 'Accounts'],
    ['title' => 'Expenses', 'icon' => 'bi-currency-rupee', 'url' => '', 'permission' => 'accounts_expenses', 'parent' => 'Accounts'],
    ['title' => 'Profit & Loss', 'icon' => 'bi-currency-rupee', 'url' => '', 'permission' => 'accounts_profit_loss', 'parent' => 'Accounts'],
    ['title' => 'Cash / Bank Report', 'icon' => 'bi-currency-rupee', 'url' => '', 'permission' => 'accounts_cash_bank', 'parent' => 'Accounts'],

    // Communication
    ['title' => 'SMS Alerts', 'icon' => 'bi-chat-dots', 'url' => '', 'permission' => 'communication_sms', 'parent' => 'Communication'],
    ['title' => 'Email Notifications', 'icon' => 'bi-chat-dots', 'url' => '', 'permission' => 'communication_email', 'parent' => 'Communication'],
    ['title' => 'WhatsApp Integration', 'icon' => 'bi-chat-dots', 'url' => '', 'permission' => 'communication_whatsapp', 'parent' => 'Communication'],

    // Settings
    ['title' => 'Hospital Profile', 'icon' => 'bi-gear-fill', 'url' => '', 'permission' => 'settings_hospital_profile', 'parent' => 'Settings'],
    ['title' => 'Department Setup', 'icon' => 'bi-gear-fill', 'url' => '', 'permission' => 'settings_department', 'parent' => 'Settings'],
    ['title' => 'Bed Types', 'icon' => 'bi-gear-fill', 'url' => '', 'permission' => 'settings_bed_types', 'parent' => 'Settings'],
    ['title' => 'Charges Configuration', 'icon' => 'bi-gear-fill', 'url' => '', 'permission' => 'settings_charges', 'parent' => 'Settings'],
    ['title' => 'User Management', 'icon' => 'bi-gear-fill', 'url' => '', 'permission' => 'settings_user_management', 'parent' => 'Settings'],
    ['title' => 'Backup & Restore', 'icon' => 'bi-gear-fill', 'url' => '', 'permission' => 'settings_backup_restore', 'parent' => 'Settings'],

    // Help / Support
    ['title' => 'Help Center', 'icon' => 'bi-question-circle', 'url' => '', 'permission' => 'help_center', 'parent' => 'Help / Support'],
    ['title' => 'User Guide', 'icon' => 'bi-question-circle', 'url' => '', 'permission' => 'help_user_guide', 'parent' => 'Help / Support'],
    ['title' => 'Support Tickets', 'icon' => 'bi-question-circle', 'url' => '', 'permission' => 'help_support_tickets', 'parent' => 'Help / Support'],
];
