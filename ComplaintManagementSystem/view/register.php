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

            <form method="POST">

                <label>Email Address</label>
                <input type="email" name="email">

                <label>First Name</label>
                <input type="text" name="firstName">

                <label>Last Name</label>
                <input type="text" name="lastName">

                <label>Street Address</label>
                <input type="text" name="streetAddress">

                <label>City</label>
                <input type="text" name="city">

                <label>State</label>
                <input
                    type="text"
                    name="state"
                    maxlength="2"
                >

                <label>Zip Code</label>
                <input type="text" name="zipCode">

                <label>Phone Number</label>
                <input type="text" name="phoneNumber">

                <label>Password</label>
                <input type="password" name="password">

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