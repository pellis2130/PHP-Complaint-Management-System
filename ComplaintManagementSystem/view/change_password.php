<?php

session_start();

if (!isset($_SESSION['employee_id'])) {
    header("Location: login.php");
    exit;
}

if (
    ($_SESSION['user_type'] ?? '') !== 'Technician' &&
    ($_SESSION['user_type'] ?? '') !== 'Administrator'
) {
    header("Location: login.php");
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Change Password - Complaint Management System</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>

<body>

    <header>
        <h1>Complaint Management System</h1>
        <p>Change Password</p>
    </header>

    <main>

        <section class="card">

            <h2>Change Password</h2>

            <?php if (isset($_GET['success'])) : ?>
                <p class="success">
                    Your password was changed successfully.
                </p>
            <?php endif; ?>

            <?php if (isset($_GET['error'])) : ?>
                <p class="error">
                    <?php
                    if ($_GET['error'] === 'current') {
                        echo "Your current password is incorrect.";
                    } elseif ($_GET['error'] === 'match') {
                        echo "Your new passwords do not match.";
                    } else {
                        echo "Please complete all fields.";
                    }
                    ?>
                </p>
            <?php endif; ?>

            <form
                method="POST"
                action="../controller/password_controller.php"
            >

                <label for="current_password">
                    Current Password
                </label>

                <input
                    type="password"
                    id="current_password"
                    name="current_password"
                    required
                >

                <label for="new_password">
                    New Password
                </label>

                <input
                    type="password"
                    id="new_password"
                    name="new_password"
                    required
                >

                <label for="confirm_password">
                    Confirm New Password
                </label>

                <input
                    type="password"
                    id="confirm_password"
                    name="confirm_password"
                    required
                >

                <input
                    type="submit"
                    value="Change Password"
                >

            </form>

            <?php if ($_SESSION['user_type'] === 'Administrator') : ?>

                <a href="admin_home.php" class="button">
                    Back to Dashboard
                </a>

            <?php else : ?>

                <a href="technician_home.php" class="button">
                    Back to Dashboard
                </a>

            <?php endif; ?>

        </section>

    </main>

</body>

</html>