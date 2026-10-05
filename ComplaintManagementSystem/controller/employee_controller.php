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
require_once __DIR__ . '/../includes/validation.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: ../view/admin_users.php");
    exit;
}

$action = $_POST['action'] ?? '';

/*
 * Make sure the action is valid.
 */
if (!in_array($action, ['Add', 'Update'], true)) {
    header("Location: ../view/admin_users.php");
    exit;
}

/*
 * Set the correct page to return to
 * if validation fails.
 */
$employeeId = 0;
$formLocation = "../view/admin_employee.php";

if ($action === 'Update') {
    $employeeId = (int) ($_POST['employee_id'] ?? 0);

    if ($employeeId <= 0) {
        header("Location: ../view/admin_users.php");
        exit;
    }

    $formLocation =
        "../view/admin_employee.php?id=" . $employeeId;
}

$firstName = trim($_POST['first_name'] ?? '');
$lastName = trim($_POST['last_name'] ?? '');
$email = trim($_POST['email'] ?? '');
$phoneExtension = trim($_POST['phone_extension'] ?? '');
$level = $_POST['level'] ?? '';

/*
 * Validate common employee fields.
 */
if (
    !validateRequired($firstName) ||
    !validateRequired($lastName) ||
    !validateRequired($email) ||
    !validateRequired($phoneExtension)
) {
    $_SESSION['employee_error'] =
        "Please complete all required fields.";

    header("Location: " . $formLocation);
    exit;
}

if (!validateLength($firstName, 1, 50)) {
    $_SESSION['employee_error'] =
        "First name must be 50 characters or less.";

    header("Location: " . $formLocation);
    exit;
}

if (!validateLength($lastName, 1, 50)) {
    $_SESSION['employee_error'] =
        "Last name must be 50 characters or less.";

    header("Location: " . $formLocation);
    exit;
}

if (
    !validateEmail($email) ||
    !validateLength($email, 5, 100)
) {
    $_SESSION['employee_error'] =
        "Please enter a valid email address.";

    header("Location: " . $formLocation);
    exit;
}

/*
 * Phone extension is VARCHAR(10)
 * and should contain only numbers.
 */
if (
    !validateLength($phoneExtension, 1, 10) ||
    !ctype_digit($phoneExtension)
) {
    $_SESSION['employee_error'] =
        "Phone extension must contain only numbers and " .
        "be 10 digits or less.";

    header("Location: " . $formLocation);
    exit;
}

if (
    !in_array(
        $level,
        ['Technician', 'Administrator'],
        true
    )
) {
    $_SESSION['employee_error'] =
        "Please select a valid employee level.";

    header("Location: " . $formLocation);
    exit;
}


/*
 * Add employee.
 */
if ($action === 'Add') {

    $userId = trim($_POST['user_id'] ?? '');
    $password = $_POST['password'] ?? '';

    if (
        !validateRequired($userId) ||
        !validateRequired($password)
    ) {
        $_SESSION['employee_error'] =
            "User ID and password are required.";

        header("Location: " . $formLocation);
        exit;
    }

    if (!validateLength($userId, 1, 50)) {
        $_SESSION['employee_error'] =
            "User ID must be 50 characters or less.";

        header("Location: " . $formLocation);
        exit;
    }

    if (!validatePassword($password)) {
        $_SESSION['employee_error'] =
            "Password must be at least 8 characters and " .
            "include an uppercase letter, lowercase letter, " .
            "number, and special character.";

        header("Location: " . $formLocation);
        exit;
    }

    if (EmployeeDB::getEmployeeByUserId($userId)) {
        $_SESSION['employee_error'] =
            "That User ID is already being used.";

        header("Location: " . $formLocation);
        exit;
    }

    if (EmployeeDB::getEmployeeByEmail($email)) {
        $_SESSION['employee_error'] =
            "That email address is already being used.";

        header("Location: " . $formLocation);
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

    header(
        "Location: ../view/admin_users.php?added=1"
    );
    exit;
}


/*
 * Update employee.
 */
if ($action === 'Update') {

    $currentEmployee =
        EmployeeDB::getEmployee($employeeId);

    if (!$currentEmployee) {
        header("Location: ../view/admin_users.php");
        exit;
    }

    $emailEmployee =
        EmployeeDB::getEmployeeByEmail($email);

    if (
        $emailEmployee &&
        $emailEmployee->getEmployeeId() !== $employeeId
    ) {
        $_SESSION['employee_error'] =
            "That email address is already being used.";

        header("Location: " . $formLocation);
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

    header(
        "Location: ../view/admin_users.php?updated=1"
    );
    exit;
}

header("Location: ../view/admin_users.php");
exit;

?>