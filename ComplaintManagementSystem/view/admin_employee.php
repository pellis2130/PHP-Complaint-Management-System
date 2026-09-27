<?php

session_start();

if (
    !isset($_SESSION['employee_id']) ||
    ($_SESSION['user_type'] ?? '') !== 'Administrator'
) {
    header("Location: login.php");
    exit;
}

require_once __DIR__ . '/../model/employee_db.php';

$employee = null;
$editing = false;

if (isset($_GET['id'])) {
    $employeeId = (int) $_GET['id'];
    $employee = EmployeeDB::getEmployee($employeeId);

    if ($employee) {
        $editing = true;
    }
}

$error = $_SESSION['employee_error'] ?? '';
unset($_SESSION['employee_error']);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">

    <title>
        <?php echo $editing ? 'Update Employee' : 'Add Employee'; ?>
    </title>

    <link rel="stylesheet" href="../css/styles.css">
</head>

<body>

<header>
    <h1>Complaint Management System</h1>

    <p>
        <?php echo $editing ? 'Update Employee' : 'Add Employee'; ?>
    </p>
</header>

<main>

<section class="card">

    <h2>
        <?php echo $editing ? 'Update Employee' : 'Add Employee'; ?>
    </h2>

    <?php if ($error !== '') : ?>

        <p class="error">
            <?php echo htmlspecialchars($error); ?>
        </p>

    <?php endif; ?>

    <form action="../controller/employee_controller.php" method="post">

        <input
            type="hidden"
            name="action"
            value="<?php echo $editing ? 'Update' : 'Add'; ?>"
        >

        <?php if ($editing) : ?>

            <input
                type="hidden"
                name="employee_id"
                value="<?php echo $employee->getEmployeeId(); ?>"
            >

        <?php endif; ?>

        <label for="user_id">User ID:</label>

        <?php if ($editing) : ?>

            <input
                type="text"
                id="user_id"
                value="<?php echo htmlspecialchars($employee->getUserId()); ?>"
                disabled
            >

        <?php else : ?>

            <input
                type="text"
                id="user_id"
                name="user_id"
                required
            >

        <?php endif; ?>


        <label for="first_name">First Name:</label>

        <input
            type="text"
            id="first_name"
            name="first_name"
            value="<?php
                echo $editing
                    ? htmlspecialchars($employee->getFirstName())
                    : '';
            ?>"
            required
        >


        <label for="last_name">Last Name:</label>

        <input
            type="text"
            id="last_name"
            name="last_name"
            value="<?php
                echo $editing
                    ? htmlspecialchars($employee->getLastName())
                    : '';
            ?>"
            required
        >


        <label for="email">Email:</label>

        <input
            type="email"
            id="email"
            name="email"
            value="<?php
                echo $editing
                    ? htmlspecialchars($employee->getEmail())
                    : '';
            ?>"
            required
        >


        <label for="phone_extension">Phone Extension:</label>

        <input
            type="text"
            id="phone_extension"
            name="phone_extension"
            value="<?php
                echo $editing
                    ? htmlspecialchars($employee->getPhoneExtension())
                    : '';
            ?>"
            required
        >


        <label for="level">Employee Level:</label>

        <select id="level" name="level" required>

            <option value="">Select Level</option>

            <option
                value="Technician"
                <?php
                if (
                    $editing &&
                    $employee->getLevel() === 'Technician'
                ) {
                    echo 'selected';
                }
                ?>
            >
                Technician
            </option>

            <option
                value="Administrator"
                <?php
                if (
                    $editing &&
                    $employee->getLevel() === 'Administrator'
                ) {
                    echo 'selected';
                }
                ?>
            >
                Administrator
            </option>

        </select>


        <?php if (!$editing) : ?>

            <label for="password">Temporary Password:</label>

            <input
                type="password"
                id="password"
                name="password"
                required
            >

        <?php endif; ?>


        <button type="submit">
            <?php echo $editing ? 'Update Employee' : 'Add Employee'; ?>
        </button>

    </form>

    <br>

    <a href="admin_users.php" class="button">
        Back to Users
    </a>

</section>

</main>

</body>

</html>