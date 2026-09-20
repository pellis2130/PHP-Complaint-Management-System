<?php

session_start();

if (
    !isset($_SESSION['customer_id']) ||
    ($_SESSION['user_type'] ?? '') !== 'Customer'
) {
    header("Location: login.php");
    exit;
}

require_once __DIR__ . '/../model/complaint_db.php';
require_once __DIR__ . '/../model/product_db.php';
require_once __DIR__ . '/../model/complaint_type_db.php';

$customerId = $_SESSION['customer_id'];

$complaints = ComplaintDB::getComplaintsByCustomer($customerId);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>My Complaints - Complaint Management System</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>

<body>

    <header>
        <h1>Complaint Management System</h1>
        <p>My Complaints</p>
    </header>

    <main>

        <section class="card">

            <h2>Your Complaints</h2>

            <?php if (count($complaints) === 0) : ?>

                <p>
                    You have not submitted any complaints yet.
                </p>

            <?php else : ?>

                <?php foreach ($complaints as $complaint) : ?>

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

                        <p>
                            <strong>Date Submitted:</strong>

                            <?php
                            echo htmlspecialchars(
                                $complaint->getDateCreated()
                            );
                            ?>
                        </p>

                    </div>

                <?php endforeach; ?>

            <?php endif; ?>

            <a href="customer_home.php" class="button">
                Back to Dashboard
            </a>

        </section>

    </main>

</body>

</html>