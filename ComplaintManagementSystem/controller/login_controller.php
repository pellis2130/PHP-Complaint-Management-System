<?php

session_start();

require_once __DIR__ . '/../model/customer.php';
require_once __DIR__ . '/../model/customer_db.php';
require_once __DIR__ . '/../model/employee.php';
require_once __DIR__ . '/../model/employee_db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($username === '' || $password === '') {
        $error = "Please enter your username and password.";
        require __DIR__ . '/../view/login.php';
        exit;
    }

    // Check for a customer using their email
    $customer = CustomerDB::getCustomerByEmail($username);

    if ($customer && password_verify($password, $customer->getPassword())) {

        session_regenerate_id(true);
    
        $_SESSION['customer_id'] = $customer->getCustomerId();
        $_SESSION['first_name'] = $customer->getFirstName();
        $_SESSION['user_type'] = 'Customer';

        header("Location: ../view/customer_home.php");
        exit;
    }

    // Check for an employee using their User ID
    $employee = EmployeeDB::getEmployeeByUserId($username);

    if ($employee && password_verify($password, $employee->getPassword())) {

        session_regenerate_id(true);

        $_SESSION['employee_id'] = $employee->getEmployeeId();
        $_SESSION['first_name'] = $employee->getFirstName();
        $_SESSION['user_type'] = $employee->getLevel();

        if ($employee->getLevel() === 'Administrator') {
            header("Location: ../view/admin_home.php");
        } else {
            header("Location: ../view/technician_home.php");
        }

        exit;
    }

    $error = "Invalid username or password.";
    require __DIR__ . '/../view/login.php';
    exit;
}
?>