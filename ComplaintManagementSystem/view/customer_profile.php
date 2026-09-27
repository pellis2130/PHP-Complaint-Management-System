<?php

session_start();

if (
    !isset($_SESSION['customer_id']) ||
    ($_SESSION['user_type'] ?? '') !== 'Customer'
) {
    header("Location: login.php");
    exit;
}

require_once __DIR__ . '/../model/customer_db.php';

$customerId = (int) $_SESSION['customer_id'];
$customer = CustomerDB::getCustomer($customerId);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Update Profile - Complaint Management System</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>

<body>

    <header>
        <h1>Complaint Management System</h1>
        <p>Customer Profile</p>
    </header>

    <main>

        <section class="card">

            <h2>Update My Profile</h2>

            <?php if (isset($_GET['updated'])) : ?>
                <p class="success">
                    Your profile was updated successfully.
                </p>
            <?php endif; ?>

            <?php if (isset($_GET['error'])) : ?>
                <p class="error">
                    Please complete all required fields.
                </p>
            <?php endif; ?>

            <form
                method="POST"
                action="../controller/profile_controller.php"
            >

                <label for="email">Email Address</label>
                <input
                    type="email"
                    id="email"
                    name="email"
                    value="<?php echo htmlspecialchars($customer->getEmail()); ?>"
                    required
                >

                <label for="first_name">First Name</label>
                <input
                    type="text"
                    id="first_name"
                    name="first_name"
                    value="<?php echo htmlspecialchars($customer->getFirstName()); ?>"
                    required
                >

                <label for="last_name">Last Name</label>
                <input
                    type="text"
                    id="last_name"
                    name="last_name"
                    value="<?php echo htmlspecialchars($customer->getLastName()); ?>"
                    required
                >

                <label for="street_address">Street Address</label>
                <input
                    type="text"
                    id="street_address"
                    name="street_address"
                    value="<?php echo htmlspecialchars($customer->getStreetAddress()); ?>"
                    required
                >

                <label for="city">City</label>
                <input
                    type="text"
                    id="city"
                    name="city"
                    value="<?php echo htmlspecialchars($customer->getCity()); ?>"
                    required
                >

                <label for="state">State</label>
                <input
                    type="text"
                    id="state"
                    name="state"
                    maxlength="2"
                    value="<?php echo htmlspecialchars($customer->getState()); ?>"
                    required
                >

                <label for="zip_code">Zip Code</label>
                <input
                    type="text"
                    id="zip_code"
                    name="zip_code"
                    value="<?php echo htmlspecialchars($customer->getZipCode()); ?>"
                    required
                >

                <label for="phone_number">Phone Number</label>
                <input
                    type="text"
                    id="phone_number"
                    name="phone_number"
                    value="<?php echo htmlspecialchars($customer->getPhoneNumber()); ?>"
                    required
                >

                <input
                    type="submit"
                    value="Update Profile"
                >

            </form>

            <a href="customer_home.php" class="button">
                Back to Dashboard
            </a>

        </section>

    </main>

</body>

</html>