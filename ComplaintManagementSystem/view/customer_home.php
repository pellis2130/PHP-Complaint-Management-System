<?php

session_start();

if (
    !isset($_SESSION['customer_id']) ||
    ($_SESSION['user_type'] ?? '') !== 'Customer'
) {
    header("Location: login.php");
    exit;
}

$firstName = $_SESSION['first_name'] ?? '';

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Customer Home - Complaint Management System</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>

<body>

    <header>
        <h1>Complaint Management System</h1>
        <p>Customer Dashboard</p>
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

            <a href="new_complaint.php" class="button">
                Submit a Complaint
            </a>

            <a href="my_complaints.php" class="button">
                View My Complaints
            </a>

            <a href="customer_profile.php" class="button">
                Update My Profile
            </a>

            <a href="../controller/logout_controller.php" class="button">
                Logout
            </a>

        </section>

    </main>

</body>

</html>