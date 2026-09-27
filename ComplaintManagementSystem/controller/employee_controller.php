<?php

session_start();

if (
    !isset($_SESSION['employee_id']) ||
    ($_SESSION['user_type'] ?? '') !== 'Administrator'
) {
    header("Location: ../view/login.php");
    exit;
}

require_once __DIR__ . '/../model/employee.php';
require_once __DIR__ . '/../model/employee_db.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: ../view/admin_users.php");
    exit;
}

$action = $_POST['action'] ?? '';

$firstName = trim($_POST['first_name'] ?? '');
$lastName = trim($_POST['last_name'] ?? '');
$email = trim($_POST['email'] ?? '');
$phoneExtension = trim($_POST['phone_extension'] ?? '');
$level = $_POST['level'] ?? '';

if (
    $firstName === '' ||
    $lastName === '' ||
    $email === '' ||
    $phoneExtension === '' ||
    !filter_var($email, FILTER_VALIDATE_EMAIL) ||
    !in_array($level, ['Technician', 'Administrator'], true)
) {
    $_SESSION['employee_error'] =
        "Please enter valid information in all fields.";

    header("Location: ../view/admin_employee.php");
    exit;
}

if ($action === 'Add') {

    $userId = trim($_POST['user_id'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($userId === '' || $password === '') {
        $_SESSION['employee_error'] =
            "User ID and password are required.";

        header("Location: ../view/admin_employee.php");
        exit;
    }

    if (EmployeeDB::getEmployeeByUserId($userId)) {
        $_SESSION['employee_error'] =
            "That User ID is already being used.";

        header("Location: ../view/admin_employee.php");
        exit;
    }

    if (EmployeeDB::getEmployeeByEmail($email)) {
        $_SESSION['employee_error'] =
            "That email address is already being used.";

        header("Location: ../view/admin_employee.php");
        exit;
    }

    $hashedPassword = password_hash(
        $password,
        PASSWORD_DEFAULT
    );

    $employee = new Employee(
        null,
        $userId,
        $firstName,
        $lastName,
        $email,
        $phoneExtension,
        $hashedPassword,
        $level
    );

    EmployeeDB::addEmployee($employee);

    header("Location: ../view/admin_users.php?added=1");
    exit;
}


if ($action === 'Update') {

    $employeeId = (int) ($_POST['employee_id'] ?? 0);

    $currentEmployee = EmployeeDB::getEmployee($employeeId);

    if (!$currentEmployee) {
        header("Location: ../view/admin_users.php");
        exit;
    }

    $emailEmployee = EmployeeDB::getEmployeeByEmail($email);

    if (
        $emailEmployee &&
        $emailEmployee->getEmployeeId() !== $employeeId
    ) {
        $_SESSION['employee_error'] =
            "That email address is already being used.";

        header(
            "Location: ../view/admin_employee.php?id=" .
            $employeeId
        );
        exit;
    }

    $employee = new Employee(
        $employeeId,
        $currentEmployee->getUserId(),
        $firstName,
        $lastName,
        $email,
        $phoneExtension,
        $currentEmployee->getPassword(),
        $level
    );

    EmployeeDB::updateEmployee($employee);

    header("Location: ../view/admin_users.php?updated=1");
    exit;
}

header("Location: ../view/admin_users.php");
exit;

?>