<?php

session_start();

if (
    !isset($_SESSION['employee_id']) ||
    ($_SESSION['user_type'] ?? '') !== 'Administrator'
) {
    header("Location: login.php");
    exit;
}

require_once __DIR__ . '/../model/customer_db.php';

$customerId = (int) ($_GET['id'] ?? 0);
$customer = CustomerDB::getCustomer($customerId);

if (!$customer) {
    header("Location: admin_users.php");
    exit;
}

$error = $_SESSION['customer_admin_error'] ?? '';
unset($_SESSION['customer_admin_error']);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Update Customer</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>

<body>

<header>
    <h1>Complaint Management System</h1>
    <p>Update Customer</p>
</header>

<main>

<section class="card">

    <h2>Update Customer</h2>

    <?php if ($error !== '') : ?>

        <p class="error">
            <?php echo htmlspecialchars($error); ?>
        </p>

    <?php endif; ?>

    <form
        action="../controller/admin_customer_controller.php"
        method="post"
    >

        <input
            type="hidden"
            name="customer_id"
            value="<?php echo $customer->getCustomerId(); ?>"
        >


        <label for="email">
            Email:
        </label>

        <input
            type="email"
            id="email"
            name="email"
            maxlength="100"
            value="<?php
            echo htmlspecialchars(
                $customer->getEmail()
            );
            ?>"
            required
        >


        <label for="first_name">
            First Name:
        </label>

        <input
            type="text"
            id="first_name"
            name="first_name"
            maxlength="50"
            value="<?php
            echo htmlspecialchars(
                $customer->getFirstName()
            );
            ?>"
            required
        >


        <label for="last_name">
            Last Name:
        </label>

        <input
            type="text"
            id="last_name"
            name="last_name"
            maxlength="50"
            value="<?php
            echo htmlspecialchars(
                $customer->getLastName()
            );
            ?>"
            required
        >


        <label for="street_address">
            Street Address:
        </label>

        <input
            type="text"
            id="street_address"
            name="street_address"
            maxlength="100"
            value="<?php
            echo htmlspecialchars(
                $customer->getStreetAddress()
            );
            ?>"
            required
        >


        <label for="city">
            City:
        </label>

        <input
            type="text"
            id="city"
            name="city"
            maxlength="50"
            value="<?php
            echo htmlspecialchars(
                $customer->getCity()
            );
            ?>"
            required
        >


        <label for="state">
            State:
        </label>

        <input
            type="text"
            id="state"
            name="state"
            minlength="2"
            maxlength="2"
            value="<?php
            echo htmlspecialchars(
                $customer->getState()
            );
            ?>"
            required
        >


        <label for="zip_code">
            ZIP Code:
        </label>

        <input
            type="text"
            id="zip_code"
            name="zip_code"
            maxlength="10"
            placeholder="12345 or 12345-6789"
            value="<?php
            echo htmlspecialchars(
                $customer->getZipCode()
            );
            ?>"
            required
        >


        <label for="phone_number">
            Phone Number:
        </label>

        <input
            type="text"
            id="phone_number"
            name="phone_number"
            maxlength="20"
            placeholder="555-555-5555"
            value="<?php
            echo htmlspecialchars(
                $customer->getPhoneNumber()
            );
            ?>"
            required
        >


        <button type="submit">
            Update Customer
        </button>

    </form>

    <br>

    <a
        href="admin_users.php"
        class="button"
    >
        Back to Users
    </a>

</section>

</main>

</body>

</html>