<?php

session_start();

if (
    !isset($_SESSION['customer_id']) ||
    ($_SESSION['user_type'] ?? '') !== 'Customer'
) {
    header("Location: login.php");
    exit;
}

require_once __DIR__ . '/../model/product_db.php';
require_once __DIR__ . '/../model/complaint_type_db.php';

$products = ProductDB::getProducts();
$complaintTypes = ComplaintTypeDB::getComplaintTypes();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Submit Complaint - Complaint Management System</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>

<body>

    <header>
        <h1>Complaint Management System</h1>
        <p>Submit a Complaint</p>
    </header>

    <main>

        <section class="card">

            <h2>New Complaint</h2>

            <p>
                Please provide the information about your complaint below.
            </p>

            <?php if (isset($_GET['success'])) : ?>
                <p class="success">
                    Your complaint was submitted successfully.
                </p>
            <?php endif; ?>

            <?php if (isset($_GET['error'])) : ?>
                <p class="error">
                    Please complete all required fields.
                </p>
            <?php endif; ?>

            <form method="POST"
                  action="../controller/complaint_controller.php">

                <label for="product_id">
                    Product or Service
                </label>

                <select
                    id="product_id"
                    name="product_id"
                    required
                >
                    <option value="">
                        Select a product or service
                    </option>

                    <?php foreach ($products as $product) : ?>

                        <?php if ($product->getActive()) : ?>

                            <option
                                value="<?php echo $product->getProductId(); ?>"
                            >
                                <?php
                                echo htmlspecialchars(
                                    $product->getProductName()
                                );
                                ?>
                            </option>

                        <?php endif; ?>

                    <?php endforeach; ?>

                </select>


                <label for="complaint_type_id">
                    Complaint Type
                </label>

                <select
                    id="complaint_type_id"
                    name="complaint_type_id"
                    required
                >
                    <option value="">
                        Select a complaint type
                    </option>

                    <?php foreach ($complaintTypes as $type) : ?>

                        <?php if ($type->getActive()) : ?>

                            <option
                                value="<?php echo $type->getComplaintTypeId(); ?>"
                            >
                                <?php
                                echo htmlspecialchars(
                                    $type->getTypeName()
                                );
                                ?>
                            </option>

                        <?php endif; ?>

                    <?php endforeach; ?>

                </select>


                <label for="description">
                    Complaint Description
                </label>

                <textarea
                    id="description"
                    name="description"
                    rows="6"
                    required
                    placeholder="Describe the problem you are experiencing..."
                ></textarea>


                <input
                    type="submit"
                    value="Submit Complaint"
                >

            </form>

            <a href="customer_home.php" class="button">
                Back to Dashboard
            </a>

        </section>

    </main>

</body>

</html>