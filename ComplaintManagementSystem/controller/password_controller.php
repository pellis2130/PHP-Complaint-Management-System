<?php

session_start();

require_once __DIR__ . '/../model/employee.php';
require_once __DIR__ . '/../model/employee_db.php';

if (!isset($_SESSION['employee_id'])) {
    header("Location: ../view/login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $currentPassword = $_POST['current_password'] ?? '';
    $newPassword = $_POST['new_password'] ?? '';
    $confirmPassword = $_POST['confirm_password'] ?? '';

    if (
        $currentPassword === '' ||
        $newPassword === '' ||
        $confirmPassword === ''
    ) {
        header("Location: ../view/change_password.php?error=empty");
        exit;
    }

    $employeeId = $_SESSION['employee_id'];

    $employee = EmployeeDB::getEmployee($employeeId);

    if (!$employee) {
        header("Location: ../view/login.php");
        exit;
    }

    if (!password_verify(
        $currentPassword,
        $employee->getPassword()
    )) {
        header("Location: ../view/change_password.php?error=current");
        exit;
    }

    if ($newPassword !== $confirmPassword) {
        header("Location: ../view/change_password.php?error=match");
        exit;
    }

    $hashedPassword = password_hash(
        $newPassword,
        PASSWORD_DEFAULT
    );

    EmployeeDB::updatePassword(
        $employeeId,
        $hashedPassword
    );

    header("Location: ../view/change_password.php?success=1");
    exit;
}

header("Location: ../view/change_password.php");
exit;

?>