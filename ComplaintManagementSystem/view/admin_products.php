<?php

session_start();

if (
    !isset($_SESSION['employee_id']) ||
    ($_SESSION['user_type'] ?? '') !== 'Administrator'
) {
    header("Location: login.php");
    exit;
}

require_once __DIR__ . '/../model/product_db.php';

$products = ProductDB::getProducts();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Manage Products and Services</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>

<body>

<header>
    <h1>Complaint Management System</h1>
    <p>Manage Products / Services</p>
</header>

<main>

<section class="card">

    <h2>Products and Services</h2>

    <?php if (isset($_GET['added'])) : ?>
        <p class="success">
            Product or service added successfully.
        </p>
    <?php endif; ?>

    <?php if (isset($_GET['deleted'])) : ?>
        <p class="success">
            Product or service removed successfully.
        </p>
    <?php endif; ?>

    <?php if (count($products) === 0) : ?>

        <p>No products or services found.</p>

    <?php else : ?>

        <?php foreach ($products as $product) : ?>

            <div class="complaint">

                <p>
                    <strong>Name:</strong>
                    <?php
                    echo htmlspecialchars(
                        $product->getProductName()
                    );
                    ?>
                </p>

                <p>
                    <strong>Description:</strong>
                    <?php
                    echo htmlspecialchars(
                        $product->getDescription()
                    );
                    ?>
                </p>

                <p>
                    <strong>Status:</strong>

                    <?php if ($product->getActive()) : ?>
                        Active
                    <?php else : ?>
                        Inactive
                    <?php endif; ?>
                </p>

                <form
                    method="POST"
                    action="../controller/product_controller.php"
                >

                    <input
                        type="hidden"
                        name="product_id"
                        value="<?php echo $product->getProductId(); ?>"
                    >

                    <input
                        type="submit"
                        name="action"
                        value="Remove"
                    >

                </form>

            </div>

        <?php endforeach; ?>

    <?php endif; ?>

    <hr>

    <h2>Add Product / Service</h2>

    <form
        method="POST"
        action="../controller/product_controller.php"
    >

        <label for="product_name">
            Product / Service Name
        </label>

        <input
            type="text"
            id="product_name"
            name="product_name"
            required
        >

        <label for="description">
            Description
        </label>

        <textarea
            id="description"
            name="description"
            rows="4"
            required
        ></textarea>

        <input
            type="submit"
            name="action"
            value="Add"
        >

    </form>

    <a href="admin_home.php" class="button">
        Back to Dashboard
    </a>

</section>

</main>

</body>

</html>