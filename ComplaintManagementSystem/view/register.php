<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Register - Complaint Management System</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>

<body>

    <header>
        <h1>Complaint Management System</h1>
        <p>Create Customer Account</p>
    </header>

    <main>

        <section class="card">

            <h2>Register</h2>

            <?php if (isset($error)) : ?>
                <p><?php echo htmlspecialchars($error); ?></p>
            <?php endif; ?>

            <form method="POST" action="../controller/customer_controller.php">

                <label>Email Address</label>
                <input type="email" name="email" required>

                <label>First Name</label>
                <input type="text" name="first_name" required>

                <label>Last Name</label>
                <input type="text" name="last_name" required>

                <label>Street Address</label>
                <input type="text" name="street_address" required>

                <label>City</label>
                <input type="text" name="city" required>

                <label>State</label>
                <input
                    type="text"
                    name="state"
                    maxlength="2"
                    required
                >

                <label>Zip Code</label>
                <input type="text" name="zip_code" required>

                <label>Phone Number</label>
                <input type="text" name="phone_number" required>

                <label>Password</label>
                <input type="password" name="password" required>

                <input
                    type="submit"
                    value="Create Account"
                >

            </form>

            <a href="../index.php" class="button">
                Back
            </a>

        </section>

    </main>

</body>

</html>