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

            <?php if ($_GET['error'] === 'description') : ?>

                Complaint description must be 2,000
                characters or less.

            <?php else : ?>

                Please complete all required fields.

            <?php endif; ?>

        </p>

    <?php endif; ?>


    <?php if (isset($_GET['image_error'])) : ?>

        <p class="error">

            <?php if ($_GET['image_error'] === 'size') : ?>

                The image is too large.
                Please upload an image smaller than 5 MB.

            <?php elseif ($_GET['image_error'] === 'type') : ?>

                Please upload a JPG, JPEG, PNG,
                or GIF image.

            <?php elseif ($_GET['image_error'] === 'upload') : ?>

                The image could not be uploaded.
                Please try again.

            <?php elseif ($_GET['image_error'] === 'save') : ?>

                The image could not be saved.
                Please try again.

            <?php endif; ?>

        </p>

    <?php endif; ?>


    <form
        method="POST"
        action="../controller/complaint_controller.php"
        enctype="multipart/form-data"
    >

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
                        value="<?php
                        echo $product->getProductId();
                        ?>"
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
                        value="<?php
                        echo $type->getComplaintTypeId();
                        ?>"
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
            maxlength="2000"
            required
            placeholder="Describe the problem you are experiencing..."
        ></textarea>

        <small>
            Maximum 2,000 characters.
        </small>


        <label for="complaint_image">
            Complaint Image
        </label>

        <input
            type="file"
            id="complaint_image"
            name="complaint_image"
            accept=".jpg,.jpeg,.png,.gif"
        >

        <small>
            Optional. JPG, JPEG, PNG, or GIF images only.
            Maximum file size is 5 MB.
        </small>


        <input
            type="submit"
            value="Submit Complaint"
        >

    </form>


    <a
        href="customer_home.php"
        class="button"
    >
        Back to Dashboard
    </a>

</section>

</main>

</body>

</html>