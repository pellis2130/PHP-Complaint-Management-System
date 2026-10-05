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

        <p class="error">
            <?php echo htmlspecialchars($error); ?>
        </p>

    <?php endif; ?>


    <form
        method="POST"
        action="../controller/customer_controller.php"
    >

        <label for="email">
            Email Address
        </label>

        <input
            type="email"
            id="email"
            name="email"
            maxlength="100"
            required
        >


        <label for="first_name">
            First Name
        </label>

        <input
            type="text"
            id="first_name"
            name="first_name"
            maxlength="50"
            required
        >


        <label for="last_name">
            Last Name
        </label>

        <input
            type="text"
            id="last_name"
            name="last_name"
            maxlength="50"
            required
        >


        <label for="street_address">
            Street Address
        </label>

        <input
            type="text"
            id="street_address"
            name="street_address"
            maxlength="100"
            required
        >


        <label for="city">
            City
        </label>

        <input
            type="text"
            id="city"
            name="city"
            maxlength="50"
            required
        >


        <label for="state">
            State
        </label>

        <input
            type="text"
            id="state"
            name="state"
            minlength="2"
            maxlength="2"
            placeholder="VA"
            required
        >


        <label for="zip_code">
            ZIP Code
        </label>

        <input
            type="text"
            id="zip_code"
            name="zip_code"
            maxlength="10"
            placeholder="12345 or 12345-6789"
            required
        >


        <label for="phone_number">
            Phone Number
        </label>

        <input
            type="text"
            id="phone_number"
            name="phone_number"
            maxlength="20"
            placeholder="555-555-5555"
            required
        >


        <label for="password">
            Password
        </label>

        <input
            type="password"
            id="password"
            name="password"
            minlength="8"
            required
        >

        <small>
            Password must be at least 8 characters and include
            an uppercase letter, lowercase letter, number, and
            special character.
        </small>


        <input
            type="submit"
            value="Create Account"
        >

    </form>


    <a
        href="../index.php"
        class="button"
    >
        Back
    </a>

</section>

</main>

</body>

</html>