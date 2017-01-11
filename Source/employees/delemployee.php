<?php
require_once '../part/common_start_page.php';

// Get input data
$type = (isset ( $_REQUEST ['type'] )) ? $_REQUEST ['type'] : 'employee';
if ($type != 'freelancer') {
    $type = 'employee';
}

// Authenticate
if ($type == 'employee') { // Employee
    do_authenticate ( G_EMPLOYEES, F_EMPLOYEES_EMPLOYEE_LIST, TRUE );
} else { // Freelancer
    do_authenticate ( G_EMPLOYEES, F_EMPLOYEES_STAFF_LIST, TRUE );
}

$result = TRUE;
if (isset ( $_GET ['item'] ) && isset ( $_GET ['type'] )) {
    $account = $_REQUEST ['item'];
    $enable = $_REQUEST ['enable'];
    
    $valid = TRUE;
    
    // Check if account is not a freelancer
    if ($type == 'freelancer') {
        if (! is_freelancer ( $account )) {
            $valid = FALSE;
        }
    } else { // Check if account is not an employee
        if (is_freelancer ( $account )) {
            $valid = FALSE;
        }
    }
    
    if ($valid) {
        if (strtoupper ( $account ) != ACCOUNT_ADMIN) {
            $nv = new nhanvien ();
            $result = $nv->enable ( $account, $enable );
        } else {
            // Do nothing
        }
    }
    
    redirect ( "../employees/employee.php?type=$type" );
}
?>