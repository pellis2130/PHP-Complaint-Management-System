<?php

require_once(__DIR__ . '/model/database.php');

$db = new Database();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Complaint Management System</title>
    <link rel="stylesheet" href="css/styles.css">
</head>

<body>

    <header>
        <h1>Complaint Management System</h1>
        <p>Customer Support Portal</p>
    </header>

    <main>

        <section class="card">

            <h2>Welcome</h2>

            <p>
                Submit customer complaints, track complaint status,
                and manage customer support requests.
            </p>

            <?php if ($db->getConnection()) : ?>

                <p class="success">
                    Database connection successful.
                </p>

            <?php else : ?>

                <p class="error">
                    Database connection failed:
                    <?php echo $db->getError(); ?>
                </p>

            <?php endif; ?>

            <div class="buttons">

                <a href="view/register.php" class="button">
                    Create Account
                </a>

                <a href="view/login.php" class="button">
                    Login
                </a>

            </div>

        </section>

    </main>

    <footer>
        <p>
            Complaint Management System &copy; 2026
        </p>
    </footer>

</body>

</html>