<?php

session_start();

require_once __DIR__ . '/../model/employee.php';
require_once __DIR__ . '/../model/employee_db.php';
require_once __DIR__ . '/../includes/validation.php';

if (!isset($_SESSION['employee_id'])) {
    header("Location: ../view/login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $currentPassword = $_POST['current_password'] ?? '';
    $newPassword = $_POST['new_password'] ?? '';
    $confirmPassword = $_POST['confirm_password'] ?? '';

    /*
     * Make sure all password fields are completed.
     */
    if (
        !validateRequired($currentPassword) ||
        !validateRequired($newPassword) ||
        !validateRequired($confirmPassword)
    ) {
        header(
            "Location: ../view/change_password.php?error=empty"
        );
        exit;
    }

    $employeeId = (int) $_SESSION['employee_id'];

    $employee = EmployeeDB::getEmployee($employeeId);

    if (!$employee) {
        header("Location: ../view/login.php");
        exit;
    }

    /*
     * Verify the employee's current password.
     */
    if (
        !password_verify(
            $currentPassword,
            $employee->getPassword()
        )
    ) {
        header(
            "Location: ../view/change_password.php?error=current"
        );
        exit;
    }

    /*
     * Make sure the new passwords match.
     */
    if ($newPassword !== $confirmPassword) {
        header(
            "Location: ../view/change_password.php?error=match"
        );
        exit;
    }

    /*
     * New password must meet complexity requirements.
     */
    if (!validatePassword($newPassword)) {
        header(
            "Location: ../view/change_password.php?error=complexity"
        );
        exit;
    }

    /*
     * Do not allow the current password to be reused.
     */
    if (
        password_verify(
            $newPassword,
            $employee->getPassword()
        )
    ) {
        header(
            "Location: ../view/change_password.php?error=same"
        );
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

    header(
        "Location: ../view/change_password.php?success=1"
    );
    exit;
}

header("Location: ../view/change_password.php");
exit;

?>