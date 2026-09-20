<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Login - Complaint Management System</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>

<body>

    <header>
        <h1>Complaint Management System</h1>
        <p>Login</p>
    </header>

    <main>

        <section class="card">

            <h2>Account Login</h2>

            <?php if (isset($_GET['registered'])) : ?>
                <p>Account created successfully. Please log in.</p>
            <?php endif; ?>

            <?php if (isset($error)) : ?>
                <p><?php echo htmlspecialchars($error); ?></p>
            <?php endif; ?>

            <form method="POST" action="../controller/login_controller.php">

                <label for="username">
                    Email or User ID
                </label>

                <input
                    type="text"
                    id="username"
                    name="username"
                    required
                >

                <label for="password">
                    Password
                </label>

                <input
                    type="password"
                    id="password"
                    name="password"
                    required
                >

                <input
                    type="submit"
                    value="Login"
                >

            </form>

            <a href="../index.php" class="button">
                Back
            </a>

        </section>

    </main>

</body>

</html>