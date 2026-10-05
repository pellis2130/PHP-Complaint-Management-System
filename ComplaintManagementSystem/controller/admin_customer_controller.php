<?php

session_start();

if (
    !isset($_SESSION['employee_id']) ||
    ($_SESSION['user_type'] ?? '') !== 'Administrator'
) {
    header("Location: ../view/login.php");
    exit;
}

require_once __DIR__ . '/../model/customer.php';
require_once __DIR__ . '/../model/customer_db.php';
require_once __DIR__ . '/../includes/validation.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: ../view/admin_users.php");
    exit;
}

$customerId = (int) ($_POST['customer_id'] ?? 0);

if ($customerId <= 0) {
    header("Location: ../view/admin_users.php");
    exit;
}

$email = trim($_POST['email'] ?? '');
$firstName = trim($_POST['first_name'] ?? '');
$lastName = trim($_POST['last_name'] ?? '');
$streetAddress = trim($_POST['street_address'] ?? '');
$city = trim($_POST['city'] ?? '');
$state = strtoupper(trim($_POST['state'] ?? ''));
$zipCode = trim($_POST['zip_code'] ?? '');
$phoneNumber = trim($_POST['phone_number'] ?? '');

$currentCustomer = CustomerDB::getCustomer($customerId);

if (!$currentCustomer) {
    header("Location: ../view/admin_users.php");
    exit;
}

$formLocation =
    "../view/admin_customer.php?id=" . $customerId;


/*
 * Check required fields.
 */
if (
    !validateRequired($email) ||
    !validateRequired($firstName) ||
    !validateRequired($lastName) ||
    !validateRequired($streetAddress) ||
    !validateRequired($city) ||
    !validateRequired($state) ||
    !validateRequired($zipCode) ||
    !validateRequired($phoneNumber)
) {
    $_SESSION['customer_admin_error'] =
        "Please complete all customer fields.";

    header("Location: " . $formLocation);
    exit;
}


/*
 * Validate email.
 * Database field is VARCHAR(100).
 */
if (
    !validateEmail($email) ||
    !validateLength($email, 5, 100)
) {
    $_SESSION['customer_admin_error'] =
        "Please enter a valid email address.";

    header("Location: " . $formLocation);
    exit;
}


/*
 * First and last names are VARCHAR(50).
 */
if (!validateLength($firstName, 1, 50)) {
    $_SESSION['customer_admin_error'] =
        "First name must be 50 characters or less.";

    header("Location: " . $formLocation);
    exit;
}

if (!validateLength($lastName, 1, 50)) {
    $_SESSION['customer_admin_error'] =
        "Last name must be 50 characters or less.";

    header("Location: " . $formLocation);
    exit;
}


/*
 * Street address is VARCHAR(100).
 */
if (!validateLength($streetAddress, 1, 100)) {
    $_SESSION['customer_admin_error'] =
        "Street address must be 100 characters or less.";

    header("Location: " . $formLocation);
    exit;
}


/*
 * City is VARCHAR(50).
 */
if (!validateLength($city, 1, 50)) {
    $_SESSION['customer_admin_error'] =
        "City must be 50 characters or less.";

    header("Location: " . $formLocation);
    exit;
}


/*
 * State is CHAR(2).
 */
if (
    strlen($state) !== 2 ||
    !ctype_alpha($state)
) {
    $_SESSION['customer_admin_error'] =
        "State must contain two letters.";

    header("Location: " . $formLocation);
    exit;
}


/*
 * ZIP code is VARCHAR(10).
 */
if (
    !validateZip($zipCode) ||
    !validateLength($zipCode, 5, 10)
) {
    $_SESSION['customer_admin_error'] =
        "Enter a valid ZIP code, such as 12345 or 12345-6789.";

    header("Location: " . $formLocation);
    exit;
}


/*
 * Phone number is VARCHAR(20).
 */
if (!validatePhone($phoneNumber)) {
    $_SESSION['customer_admin_error'] =
        "Please enter a valid phone number.";

    header("Location: " . $formLocation);
    exit;
}


/*
 * Make sure another customer is not
 * already using this email address.
 */
$emailCustomer = CustomerDB::getCustomerByEmail($email);

if (
    $emailCustomer &&
    $emailCustomer->getCustomerId() !== $customerId
) {
    $_SESSION['customer_admin_error'] =
        "That email address is already being used.";

    header("Location: " . $formLocation);
    exit;
}


/*
 * Keep the customer's existing password.
 */
$customer = new Customer(
    $customerId,
    $email,
    $firstName,
    $lastName,
    $streetAddress,
    $city,
    $state,
    $zipCode,
    $phoneNumber,
    $currentCustomer->getPassword()
);

CustomerDB::updateCustomer($customer);

header(
    "Location: ../view/admin_users.php?customer_updated=1"
);
exit;

?>