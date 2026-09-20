<?php

session_start();

if (
    !isset($_SESSION['employee_id']) ||
    ($_SESSION['user_type'] ?? '') !== 'Administrator'
) {
    header("Location: login.php");
    exit;
}

require_once __DIR__ . '/../model/complaint_db.php';
require_once __DIR__ . '/../model/product_db.php';
require_once __DIR__ . '/../model/complaint_type_db.php';
require_once __DIR__ . '/../model/employee_db.php';

$complaints = ComplaintDB::getComplaints();
$employees = EmployeeDB::getEmployees();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Open Complaints - Complaint Management System</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>

<body>

<header>
    <h1>Complaint Management System</h1>
    <p>Open Complaints</p>
</header>

<main>

<section class="card">

    <h2>Open Customer Complaints</h2>

    <?php if (isset($_GET['assigned'])) : ?>
        <p class="success">
            Technician assigned successfully.
        </p>
    <?php endif; ?>

    <?php
    $openComplaintFound = false;

    foreach ($complaints as $complaint) :

        if ($complaint->getStatus() !== 'Open') {
            continue;
        }

        $openComplaintFound = true;

        $product = ProductDB::getProduct(
            $complaint->getProductId()
        );

        $type = ComplaintTypeDB::getComplaintType(
            $complaint->getComplaintTypeId()
        );
    ?>

        <div class="complaint">

            <h3>
                Complaint #
                <?php echo htmlspecialchars(
                    $complaint->getComplaintId()
                ); ?>
            </h3>

            <p>
                <strong>Product/Service:</strong>
                <?php echo htmlspecialchars(
                    $product->getProductName()
                ); ?>
            </p>

            <p>
                <strong>Complaint Type:</strong>
                <?php echo htmlspecialchars(
                    $type->getTypeName()
                ); ?>
            </p>

            <p>
                <strong>Description:</strong>
                <?php echo htmlspecialchars(
                    $complaint->getDescription()
                ); ?>
            </p>

            <p>
                <strong>Status:</strong>
                <?php echo htmlspecialchars(
                    $complaint->getStatus()
                ); ?>
            </p>

            <form
                method="POST"
                action="../controller/assign_controller.php"
            >

                <input
                    type="hidden"
                    name="complaint_id"
                    value="<?php echo $complaint->getComplaintId(); ?>"
                >

                <label>
                    Assign Technician
                </label>

                <select name="technician_id" required>

                    <option value="">
                        Select Technician
                    </option>

                    <?php foreach ($employees as $employee) : ?>

                        <?php
                        if ($employee->getLevel() === 'Technician') :
                        ?>

                            <option
                                value="<?php echo $employee->getEmployeeId(); ?>"
                            >
                                <?php
                                echo htmlspecialchars(
                                    $employee->getFirstName() .
                                    " " .
                                    $employee->getLastName()
                                );
                                ?>
                            </option>

                        <?php endif; ?>

                    <?php endforeach; ?>

                </select>

                <input
                    type="submit"
                    value="Assign Technician"
                >

            </form>

        </div>

    <?php endforeach; ?>

    <?php if (!$openComplaintFound) : ?>

        <p>
            There are currently no open complaints.
        </p>

    <?php endif; ?>

    <a href="admin_home.php" class="button">
        Back to Dashboard
    </a>

</section>

</main>

</body>

</html>