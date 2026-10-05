<?php

require_once __DIR__ . '/../model/customer.php';
require_once __DIR__ . '/../model/customer_db.php';
require_once __DIR__ . '/../includes/validation.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $email = trim($_POST['email'] ?? '');
    $firstName = trim($_POST['first_name'] ?? '');
    $lastName = trim($_POST['last_name'] ?? '');
    $streetAddress = trim($_POST['street_address'] ?? '');
    $city = trim($_POST['city'] ?? '');
    $state = trim($_POST['state'] ?? '');
    $zipCode = trim($_POST['zip_code'] ?? '');
    $phoneNumber = trim($_POST['phone_number'] ?? '');
    $password = $_POST['password'] ?? '';

    // Make sure all required fields are entered.
    if (
        !validateRequired($email) ||
        !validateRequired($firstName) ||
        !validateRequired($lastName) ||
        !validateRequired($streetAddress) ||
        !validateRequired($city) ||
        !validateRequired($state) ||
        !validateRequired($zipCode) ||
        !validateRequired($phoneNumber) ||
        !validateRequired($password)
    ) {
        $error = "Please fill out all fields.";
        require __DIR__ . '/../view/register.php';
        exit;
    }

    // Email database field is VARCHAR(100).
    if (
        !validateEmail($email) ||
        !validateLength($email, 5, 100)
    ) {
        $error = "Please enter a valid email address.";
        require __DIR__ . '/../view/register.php';
        exit;
    }

    // First and last name fields are VARCHAR(50).
    if (!validateLength($firstName, 1, 50)) {
        $error = "First name must be 50 characters or less.";
        require __DIR__ . '/../view/register.php';
        exit;
    }

    if (!validateLength($lastName, 1, 50)) {
        $error = "Last name must be 50 characters or less.";
        require __DIR__ . '/../view/register.php';
        exit;
    }

    // Street address field is VARCHAR(100).
    if (!validateLength($streetAddress, 1, 100)) {
        $error = "Street address must be 100 characters or less.";
        require __DIR__ . '/../view/register.php';
        exit;
    }

    // City field is VARCHAR(50).
    if (!validateLength($city, 1, 50)) {
        $error = "City must be 50 characters or less.";
        require __DIR__ . '/../view/register.php';
        exit;
    }

    // State database field is CHAR(2).
    if (
        strlen($state) !== 2 ||
        !ctype_alpha($state)
    ) {
        $error = "State must be entered using two letters.";
        require __DIR__ . '/../view/register.php';
        exit;
    }

    // ZIP database field is VARCHAR(10).
    if (
        !validateZip($zipCode) ||
        !validateLength($zipCode, 5, 10)
    ) {
        $error = "Enter a valid ZIP code, such as 12345 or 12345-6789.";
        require __DIR__ . '/../view/register.php';
        exit;
    }

    // Phone database field is VARCHAR(20).
    if (!validatePhone($phoneNumber)) {
        $error = "Please enter a valid phone number.";
        require __DIR__ . '/../view/register.php';
        exit;
    }

    // Require a strong password.
    if (!validatePassword($password)) {
        $error =
            "Password must be at least 8 characters and include " .
            "an uppercase letter, lowercase letter, number, " .
            "and special character.";

        require __DIR__ . '/../view/register.php';
        exit;
    }

    $hashedPassword = password_hash(
        $password,
        PASSWORD_DEFAULT
    );

    $customer = new Customer(
        null,
        $email,
        $firstName,
        $lastName,
        $streetAddress,
        $city,
        strtoupper($state),
        $zipCode,
        $phoneNumber,
        $hashedPassword
    );

    CustomerDB::addCustomer($customer);

    header("Location: ../view/login.php?registered=1");
    exit;
}

?>