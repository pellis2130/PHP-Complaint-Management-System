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

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: ../view/admin_users.php");
    exit;
}

$customerId = (int) ($_POST['customer_id'] ?? 0);

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

if (
    $email === '' ||
    $firstName === '' ||
    $lastName === '' ||
    $streetAddress === '' ||
    $city === '' ||
    $state === '' ||
    $zipCode === '' ||
    $phoneNumber === ''
) {
    $_SESSION['customer_admin_error'] =
        "Please complete all customer fields.";

    header(
        "Location: ../view/admin_customer.php?id=" .
        $customerId
    );
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $_SESSION['customer_admin_error'] =
        "Please enter a valid email address.";

    header(
        "Location: ../view/admin_customer.php?id=" .
        $customerId
    );
    exit;
}

if (strlen($state) !== 2) {
    $_SESSION['customer_admin_error'] =
        "State must contain two letters.";

    header(
        "Location: ../view/admin_customer.php?id=" .
        $customerId
    );
    exit;
}

$emailCustomer = CustomerDB::getCustomerByEmail($email);

if (
    $emailCustomer &&
    $emailCustomer->getCustomerId() !== $customerId
) {
    $_SESSION['customer_admin_error'] =
        "That email address is already being used.";

    header(
        "Location: ../view/admin_customer.php?id=" .
        $customerId
    );
    exit;
}

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

header("Location: ../view/admin_users.php?customer_updated=1");
exit;

?>