<?php

require_once __DIR__ . '/../model/customer.php';
require_once __DIR__ . '/../model/customer_db.php';

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

    if (
        $email === '' ||
        $firstName === '' ||
        $lastName === '' ||
        $streetAddress === '' ||
        $city === '' ||
        $state === '' ||
        $zipCode === '' ||
        $phoneNumber === '' ||
        $password === ''
    ) {
        $error = "Please fill out all fields.";
        require __DIR__ . '/../view/register.php';
        exit;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Please enter a valid email address.";
        require __DIR__ . '/../view/register.php';
        exit;
    }

    if (strlen($state) !== 2) {
        $error = "State must be entered using two letters.";
        require __DIR__ . '/../view/register.php';
        exit;
    }

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

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