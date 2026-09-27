<?php

session_start();

if (
    !isset($_SESSION['employee_id']) ||
    ($_SESSION['user_type'] ?? '') !== 'Administrator'
) {
    header("Location: login.php");
    exit;
}

require_once __DIR__ . '/../model/customer_db.php';
require_once __DIR__ . '/../model/employee_db.php';

$customers = CustomerDB::getCustomers();
$employees = EmployeeDB::getEmployees();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>View Users</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>

<body>

<header>
    <h1>Complaint Management System</h1>
    <p>View Users</p>
</header>

<main>

<section class="card">

    <h2>Customers</h2>

    <?php if (count($customers) === 0) : ?>

        <p>No customers found.</p>

    <?php else : ?>

        <?php foreach ($customers as $customer) : ?>

            <div class="complaint">

                <p>
                    <strong>Name:</strong>
                    <?php
                    echo htmlspecialchars(
                        $customer->getFirstName() . ' ' .
                        $customer->getLastName()
                    );
                    ?>
                </p>

                <p>
                    <strong>Email:</strong>
                    <?php
                    echo htmlspecialchars(
                        $customer->getEmail()
                    );
                    ?>
                </p>

                <p>
                    <strong>Phone:</strong>
                    <?php
                    echo htmlspecialchars(
                        $customer->getPhoneNumber()
                    );
                    ?>
                </p>

                <a
                    href="admin_customer.php?id=<?php
                    echo $customer->getCustomerId();
                    ?>"
                    class="button"
                >
                    Edit Customer
                </a>

            </div>

        <?php endforeach; ?>

    <?php endif; ?>

    <hr>

    <h2>Employees</h2>

    <a href="admin_employee.php" class="button">
        Add Employee
    </a>

    <br><br>

    <?php if (count($employees) === 0) : ?>

        <p>No employees found.</p>

    <?php else : ?>

        <?php foreach ($employees as $employee) : ?>

            <div class="complaint">

                <p>
                    <strong>Name:</strong>
                    <?php
                    echo htmlspecialchars(
                        $employee->getFirstName() . ' ' .
                        $employee->getLastName()
                    );
                    ?>
                </p>

                <p>
                    <strong>User ID:</strong>
                    <?php
                    echo htmlspecialchars(
                        $employee->getUserId()
                    );
                    ?>
                </p>

                <p>
                    <strong>Email:</strong>
                    <?php
                    echo htmlspecialchars(
                        $employee->getEmail()
                    );
                    ?>
                </p>

                <p>
                    <strong>Extension:</strong>
                    <?php
                    echo htmlspecialchars(
                        $employee->getPhoneExtension()
                    );
                    ?>
                </p>

                <p>
                    <strong>Level:</strong>
                    <?php
                    echo htmlspecialchars(
                        $employee->getLevel()
                    );
                    ?>
                </p>

                <a
                    href="admin_employee.php?id=<?php
                    echo $employee->getEmployeeId();
                    ?>"
                    class="button"
                >
                    Edit Employee
                </a>

            </div>

        <?php endforeach; ?>

    <?php endif; ?>

    <a href="admin_home.php" class="button">
        Back to Dashboard
    </a>

</section>

</main>

</body>

</html>