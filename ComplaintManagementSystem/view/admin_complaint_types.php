<?php

session_start();

if (
    !isset($_SESSION['employee_id']) ||
    ($_SESSION['user_type'] ?? '') !== 'Administrator'
) {
    header("Location: login.php");
    exit;
}

require_once __DIR__ . '/../model/complaint_type_db.php';

// Only show active complaint types
$complaintTypes =
    ComplaintTypeDB::getComplaintTypes();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Manage Complaint Types</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>

<body>

<header>
    <h1>Complaint Management System</h1>
    <p>Manage Complaint Types</p>
</header>

<main>

<section class="card">

    <h2>Complaint Types</h2>


    <?php if (isset($_GET['added'])) : ?>

        <p class="success">
            Complaint type added successfully.
        </p>

    <?php endif; ?>


    <?php if (isset($_GET['removed'])) : ?>

        <p class="success">
            Complaint type removed successfully.
        </p>

    <?php endif; ?>


    <?php if (isset($_GET['error'])) : ?>

        <p class="error">

            <?php

            $error = $_GET['error'];

            if ($error === 'required') {

                echo "Please complete all required fields.";

            } elseif ($error === 'name_length') {

                echo "Complaint type name is too long.";

            } elseif ($error === 'description_length') {

                echo "Description must be 2,000 characters or less.";

            } elseif ($error === 'database') {

                echo "The complaint type could not be saved.";

            } else {

                echo "The complaint type could not be processed.";

            }

            ?>

        </p>

    <?php endif; ?>


    <?php if (count($complaintTypes) === 0) : ?>

        <p>
            No complaint types found.
        </p>

    <?php else : ?>


        <?php foreach ($complaintTypes as $type) : ?>

            <div class="complaint">

                <p>
                    <strong>Type:</strong>

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
                        $type->getDescription()
                    );
                    ?>
                </p>


                <form
                    method="POST"
                    action="../controller/complaint_type_controller.php"
                >

                    <input
                        type="hidden"
                        name="complaint_type_id"
                        value="<?php
                        echo htmlspecialchars(
                            $type->getComplaintTypeId()
                        );
                        ?>"
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


    <h2>Add Complaint Type</h2>

    <form
        method="POST"
        action="../controller/complaint_type_controller.php"
    >

        <label for="type_name">
            Complaint Type Name
        </label>

        <input
            type="text"
            id="type_name"
            name="type_name"
            maxlength="100"
            required
        >


        <label for="description">
            Description
        </label>

        <textarea
            id="description"
            name="description"
            rows="4"
            maxlength="2000"
            required
        ></textarea>

        <small>
            Maximum 2,000 characters.
        </small>


        <input
            type="submit"
            name="action"
            value="Add"
        >

    </form>


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