<?php

session_start();

if (
    !isset($_SESSION['employee_id']) ||
    ($_SESSION['user_type'] ?? '') !== 'Technician'
) {
    header("Location: login.php");
    exit;
}

require_once __DIR__ . '/../model/complaint_db.php';
require_once __DIR__ . '/../model/product_db.php';
require_once __DIR__ . '/../model/complaint_type_db.php';
require_once __DIR__ . '/../model/technician_note_db.php';
require_once __DIR__ . '/../model/complaint_image_db.php';
require_once __DIR__ . '/../model/complaint_message_db.php';

$complaintId = (int) ($_GET['id'] ?? 0);
$technicianId = (int) $_SESSION['employee_id'];

$complaint = ComplaintDB::getComplaint($complaintId);

if (
    !$complaint ||
    $complaint->getTechnicianId() != $technicianId
) {
    header("Location: technician_complaints.php");
    exit;
}

$product = ProductDB::getProduct(
    $complaint->getProductId()
);

$type = ComplaintTypeDB::getComplaintType(
    $complaint->getComplaintTypeId()
);

$notes = TechnicianNoteDB::getNotesByComplaint(
    $complaintId
);

$images = ComplaintImageDB::getImagesByComplaint(
    $complaintId
);

$messages = ComplaintMessageDB::getMessagesByComplaint(
    $complaintId
);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Complaint Details - Complaint Management System</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>

<body>

<header>
    <h1>Complaint Management System</h1>
    <p>Complaint Details</p>
</header>

<main>

<section class="card">

    <h2>
        Complaint #
        <?php
        echo htmlspecialchars(
            $complaint->getComplaintId()
        );
        ?>
    </h2>


    <?php if (isset($_GET['note'])) : ?>

        <p class="success">
            Technician note added successfully.
        </p>

    <?php endif; ?>


    <?php if (isset($_GET['closed'])) : ?>

        <p class="success">
            Complaint marked as resolved.
        </p>

    <?php endif; ?>


    <?php if (isset($_GET['message_sent'])) : ?>

        <p class="success">
            Message sent successfully.
        </p>

    <?php endif; ?>


    <?php if (isset($_GET['error'])) : ?>

        <p class="error">

            <?php

            $error = $_GET['error'];

            if ($error === 'note_required') {

                echo "Please enter a technician note.";

            } elseif ($error === 'note_length') {

                echo "Technician notes must be 2,000 characters or less.";

            } elseif ($error === 'resolution_required') {

                echo "Resolution notes are required before closing a complaint.";

            } elseif ($error === 'resolution_length') {

                echo "Resolution notes must be 2,000 characters or less.";

            } else {

                echo "Please check the information entered.";

            }

            ?>

        </p>

    <?php endif; ?>


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


    <?php if (count($images) > 0) : ?>

        <hr>

        <h3>Customer Complaint Image</h3>

        <?php foreach ($images as $image) : ?>

            <img
                src="../uploads/complaints/<?php
                echo rawurlencode(
                    $image['FileName']
                );
                ?>"
                alt="Customer Complaint Image"
                style="
                    max-width: 400px;
                    max-height: 400px;
                    width: auto;
                    height: auto;
                    display: block;
                    margin: 10px auto;
                "
            >

        <?php endforeach; ?>

    <?php endif; ?>


    <hr>

    <h3>Complaint Messages</h3>


    <?php if (count($messages) === 0) : ?>

        <p>
            No messages have been sent yet.
        </p>

    <?php else : ?>

        <?php foreach ($messages as $message) : ?>

            <div class="complaint-message">

                <p>
                    <strong>
                        <?php

                        if (
                            $message['SenderType']
                            === 'Technician'
                        ) {
                            echo 'You';
                        } else {
                            echo 'Customer';
                        }

                        ?>:
                    </strong>

                    <?php
                    echo nl2br(
                        htmlspecialchars(
                            $message['MessageText']
                        )
                    );
                    ?>
                </p>

                <small>
                    <?php
                    echo htmlspecialchars(
                        $message['DateCreated']
                    );
                    ?>
                </small>

            </div>

        <?php endforeach; ?>

    <?php endif; ?>


    <?php if ($complaint->getStatus() === 'Open') : ?>

        <h3>Send Message to Customer</h3>

        <form
            method="POST"
            action="../controller/complaint_message_controller.php"
        >

            <input
                type="hidden"
                name="complaint_id"
                value="<?php
                echo $complaint->getComplaintId();
                ?>"
            >

            <label for="message_text">
                Message
            </label>

            <textarea
                id="message_text"
                name="message_text"
                rows="4"
                maxlength="2000"
                required
            ></textarea>

            <small>
                Maximum 2,000 characters.
            </small>

            <input
                type="submit"
                value="Send Message"
            >

        </form>

    <?php endif; ?>


    <hr>

    <h3>Technician Notes</h3>


    <?php if (count($notes) === 0) : ?>

        <p>
            No technician notes have been added yet.
        </p>

    <?php else : ?>

        <?php foreach ($notes as $note) : ?>

            <p>
                <?php
                echo nl2br(
                    htmlspecialchars(
                        $note->getNoteText()
                    )
                );
                ?>
            </p>

            <small>
                <?php
                echo htmlspecialchars(
                    $note->getDateCreated()
                );
                ?>
            </small>

        <?php endforeach; ?>

    <?php endif; ?>


    <?php if ($complaint->getStatus() === 'Open') : ?>

        <hr>

        <h3>Add Technician Note</h3>

        <form
            method="POST"
            action="../controller/technician_complaint_controller.php"
        >

            <input
                type="hidden"
                name="complaint_id"
                value="<?php
                echo $complaint->getComplaintId();
                ?>"
            >

            <label for="note_text">
                Note
            </label>

            <textarea
                id="note_text"
                name="note_text"
                rows="5"
                maxlength="2000"
                required
            ></textarea>

            <small>
                Maximum 2,000 characters.
            </small>

            <input
                type="submit"
                name="action"
                value="Add Note"
            >


            <label for="resolution_notes">
                Resolution Notes
            </label>

            <textarea
                id="resolution_notes"
                name="resolution_notes"
                rows="5"
                maxlength="2000"
            ></textarea>

            <small>
                Required when marking a complaint resolved.
                Maximum 2,000 characters.
            </small>

            <input
                type="submit"
                name="action"
                value="Mark Resolved"
            >

        </form>

    <?php endif; ?>


    <a
        href="technician_complaints.php"
        class="button"
    >
        Back to Assigned Complaints
    </a>

</section>

</main>

</body>

</html>