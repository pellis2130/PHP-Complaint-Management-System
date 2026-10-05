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
$unassignedComplaints = ComplaintDB::getUnassignedComplaints();
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

    <?php if (isset($_GET['assigned'])) : ?>

        <p class="success">
            Technician assigned successfully.
        </p>

    <?php endif; ?>


    <h2>Technician Workload</h2>

    <?php

    $technicianFound = false;

    foreach ($employees as $employee) :

        if ($employee->getLevel() !== 'Technician') {
            continue;
        }

        $technicianFound = true;
        $openCount = 0;

        foreach ($complaints as $complaint) {

            if (
                $complaint->getStatus() === 'Open' &&
                $complaint->getTechnicianId() ==
                $employee->getEmployeeId()
            ) {
                $openCount++;
            }
        }

    ?>

        <div class="complaint">

            <p>
                <strong>Technician:</strong>

                <?php
                echo htmlspecialchars(
                    $employee->getFirstName() .
                    " " .
                    $employee->getLastName()
                );
                ?>
            </p>

            <p>
                <strong>Open Complaints Assigned:</strong>

                <?php
                echo $openCount;
                ?>
            </p>

        </div>

    <?php endforeach; ?>

    <?php if (!$technicianFound) : ?>

        <p>
            There are currently no technicians.
        </p>

    <?php endif; ?>


    <hr>


    <h2>Unassigned Open Complaints</h2>

    <?php if (count($unassignedComplaints) === 0) : ?>

        <p>
            There are currently no unassigned open complaints.
        </p>

    <?php else : ?>

        <?php foreach ($unassignedComplaints as $complaint) : ?>

            <?php

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
                    <?php
                    echo htmlspecialchars(
                        $complaint->getComplaintId()
                    );
                    ?>
                </h3>

                <p>
                    <strong>Product/Service:</strong>

                    <?php
                    echo htmlspecialchars(
                        $product->getProductName()
                    );
                    ?>
                </p>

                <p>
                    <strong>Complaint Type:</strong>

                    <?php
                    echo htmlspecialchars(
                        $type->getTypeName()
                    );
                    ?>
                </p>

                <p>
                    <strong>Description:</strong>

                    <?php
                    echo htmlspecialchars(
                        $complaint->getDescription()
                    );
                    ?>
                </p>

                <p>
                    <strong>Status:</strong>

                    <?php
                    echo htmlspecialchars(
                        $complaint->getStatus()
                    );
                    ?>
                </p>

                <form
                    method="POST"
                    action="../controller/assign_controller.php"
                >

                    <input
                        type="hidden"
                        name="complaint_id"
                        value="<?php
                        echo $complaint->getComplaintId();
                        ?>"
                    >

                    <label>
                        Assign Technician
                    </label>

                    <select
                        name="technician_id"
                        required
                    >

                        <option value="">
                            Select Technician
                        </option>

                        <?php foreach ($employees as $employee) : ?>

                            <?php if (
                                $employee->getLevel() ===
                                'Technician'
                            ) : ?>

                                <option
                                    value="<?php
                                    echo $employee->getEmployeeId();
                                    ?>"
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

    <?php endif; ?>


    <hr>


    <h2>All Open Customer Complaints</h2>

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
                <?php
                echo htmlspecialchars(
                    $complaint->getComplaintId()
                );
                ?>
            </h3>

            <p>
                <strong>Product/Service:</strong>

                <?php
                echo htmlspecialchars(
                    $product->getProductName()
                );
                ?>
            </p>

            <p>
                <strong>Complaint Type:</strong>

                <?php
                echo htmlspecialchars(
                    $type->getTypeName()
                );
                ?>
            </p>

            <p>
                <strong>Description:</strong>

                <?php
                echo htmlspecialchars(
                    $complaint->getDescription()
                );
                ?>
            </p>

            <p>
                <strong>Status:</strong>

                <?php
                echo htmlspecialchars(
                    $complaint->getStatus()
                );
                ?>
            </p>

            <p>
                <strong>Technician:</strong>

                <?php

                if ($complaint->getTechnicianId()) {

                    $assignedEmployee =
                        EmployeeDB::getEmployee(
                            $complaint->getTechnicianId()
                        );

                    if ($assignedEmployee) {

                        echo htmlspecialchars(
                            $assignedEmployee->getFirstName() .
                            " " .
                            $assignedEmployee->getLastName()
                        );

                    } else {

                        echo "Not Assigned";
                    }

                } else {

                    echo "Not Assigned";
                }

                ?>

            </p>

            <form
                method="POST"
                action="../controller/assign_controller.php"
            >

                <input
                    type="hidden"
                    name="complaint_id"
                    value="<?php
                    echo $complaint->getComplaintId();
                    ?>"
                >

                <label>
                    Assign Technician
                </label>

                <select
                    name="technician_id"
                    required
                >

                    <option value="">
                        Select Technician
                    </option>

                    <?php foreach ($employees as $employee) : ?>

                        <?php if (
                            $employee->getLevel() ===
                            'Technician'
                        ) : ?>

                            <option
                                value="<?php
                                echo $employee->getEmployeeId();
                                ?>"
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


    <a
        href="admin_home.php"
        class="button"
    >
        Back to Dashboard
    </a>

</section>

</main>

</body>

</html>