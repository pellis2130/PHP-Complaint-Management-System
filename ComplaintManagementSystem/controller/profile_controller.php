<?php

session_start();

require_once __DIR__ . '/../model/customer.php';
require_once __DIR__ . '/../model/customer_db.php';

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
        header("Location: ../view/customer_profile.php?error=1");
        exit;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header("Location: ../view/customer_profile.php?error=1");
        exit;
    }

    if (strlen($state) !== 2) {
        header("Location: ../view/customer_profile.php?error=1");
        exit;
    }

    $customerId = $_SESSION['customer_id'];

    $currentCustomer = CustomerDB::getCustomer($customerId);

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

    header("Location: ../view/customer_profile.php?updated=1");
    exit;
}

header("Location: ../view/customer_home.php");
exit;

?>