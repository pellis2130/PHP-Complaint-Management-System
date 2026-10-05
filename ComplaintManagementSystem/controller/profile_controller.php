<?php

session_start();

require_once __DIR__ . '/../model/customer.php';
require_once __DIR__ . '/../model/customer_db.php';
require_once __DIR__ . '/../includes/validation.php';

if (
    !isset($_SESSION['customer_id']) ||
    ($_SESSION['user_type'] ?? '') !== 'Customer'
) {
    header("Location: ../view/login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $email = trim($_POST['email'] ?? '');
    $firstName = trim($_POST['first_name'] ?? '');
    $lastName = trim($_POST['last_name'] ?? '');
    $streetAddress = trim($_POST['street_address'] ?? '');
    $city = trim($_POST['city'] ?? '');
    $state = trim($_POST['state'] ?? '');
    $zipCode = trim($_POST['zip_code'] ?? '');
    $phoneNumber = trim($_POST['phone_number'] ?? '');

    // Check required fields.
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
        header(
            "Location: ../view/customer_profile.php?error=required"
        );
        exit;
    }

    // Email must be valid and fit VARCHAR(100).
    if (
        !validateEmail($email) ||
        !validateLength($email, 5, 100)
    ) {
        header(
            "Location: ../view/customer_profile.php?error=email"
        );
        exit;
    }

    // First name must fit VARCHAR(50).
    if (!validateLength($firstName, 1, 50)) {
        header(
            "Location: ../view/customer_profile.php?error=first_name"
        );
        exit;
    }

    // Last name must fit VARCHAR(50).
    if (!validateLength($lastName, 1, 50)) {
        header(
            "Location: ../view/customer_profile.php?error=last_name"
        );
        exit;
    }

    // Street address must fit VARCHAR(100).
    if (!validateLength($streetAddress, 1, 100)) {
        header(
            "Location: ../view/customer_profile.php?error=address"
        );
        exit;
    }

    // City must fit VARCHAR(50).
    if (!validateLength($city, 1, 50)) {
        header(
            "Location: ../view/customer_profile.php?error=city"
        );
        exit;
    }

    // State must match CHAR(2).
    if (
        strlen($state) !== 2 ||
        !ctype_alpha($state)
    ) {
        header(
            "Location: ../view/customer_profile.php?error=state"
        );
        exit;
    }

    // ZIP must fit VARCHAR(10) and use a valid format.
    if (
        !validateZip($zipCode) ||
        !validateLength($zipCode, 5, 10)
    ) {
        header(
            "Location: ../view/customer_profile.php?error=zip"
        );
        exit;
    }

    // Phone must use a valid format and fit VARCHAR(20).
    if (!validatePhone($phoneNumber)) {
        header(
            "Location: ../view/customer_profile.php?error=phone"
        );
        exit;
    }

    $customerId = (int) $_SESSION['customer_id'];

    $currentCustomer = CustomerDB::getCustomer(
        $customerId
    );

    if (!$currentCustomer) {
        header(
            "Location: ../view/customer_profile.php?error=customer"
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
        strtoupper($state),
        $zipCode,
        $phoneNumber,
        $currentCustomer->getPassword()
    );

    CustomerDB::updateCustomer($customer);

    $_SESSION['first_name'] = $firstName;

    header(
        "Location: ../view/customer_profile.php?updated=1"
    );
    exit;
}

header("Location: ../view/customer_home.php");
exit;

?>