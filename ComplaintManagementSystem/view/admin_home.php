<?php

session_start();

if (
    !isset($_SESSION['employee_id']) ||
    ($_SESSION['user_type'] ?? '') !== 'Administrator'
) {
    header("Location: login.php");
    exit;
}

$firstName = $_SESSION['first_name'];

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Admin Home - Complaint Management System</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>

<body>

    <header>
        <h1>Complaint Management System</h1>
        <p>Administrator Dashboard</p>
    </header>

    <main>

        <section class="card">

            <h2>
                Welcome,
                <?php echo htmlspecialchars($firstName); ?>!
            </h2>

            <p>
                What would you like to do?
            </p>

            <a href="admin_complaints.php" class="button">
                View Open Complaints
            </a>

            <a href="admin_users.php" class="button">
                View Users
            </a>

            <a href="admin_products.php" class="button">
                Manage Products / Services
            </a>

            <a href="admin_complaint_types.php" class="button">
                Manage Complaint Types
            </a>

            <a href="change_password.php" class="button">
                Change Password
            </a>

            <a href="../controller/logout_controller.php" class="button">
                Logout
            </a>

        </section>

    </main>

</body>

</html>