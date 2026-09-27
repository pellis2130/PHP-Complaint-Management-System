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

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Complaint Details</title>
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
        <?php echo htmlspecialchars($complaint->getComplaintId()); ?>
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

    <p>
        <strong>Product/Service:</strong>
        <?php echo htmlspecialchars($product->getProductName()); ?>
    </p>

    <p>
        <strong>Complaint Type:</strong>
        <?php echo htmlspecialchars($type->getTypeName()); ?>
    </p>

    <p>
        <strong>Description:</strong>
        <?php echo htmlspecialchars($complaint->getDescription()); ?>
    </p>

    <p>
        <strong>Status:</strong>
        <?php echo htmlspecialchars($complaint->getStatus()); ?>
    </p>

    <hr>

    <h3>Technician Notes</h3>

    <?php if (count($notes) === 0) : ?>

        <p>No technician notes have been added yet.</p>

    <?php else : ?>

        <?php foreach ($notes as $note) : ?>

            <p>
                <?php echo htmlspecialchars($note->getNoteText()); ?>
            </p>

            <small>
                <?php echo htmlspecialchars($note->getDateCreated()); ?>
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
                value="<?php echo $complaint->getComplaintId(); ?>"
            >

            <label for="note_text">
                Note
            </label>

            <textarea
                id="note_text"
                name="note_text"
                rows="5"
                required
            ></textarea>

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
            ></textarea>

            <input
                type="submit"
                name="action"
                value="Mark Resolved"
            >

        </form>

    <?php endif; ?>

    <a href="technician_complaints.php" class="button">
        Back to Assigned Complaints
    </a>

</section>

</main>

</body>

</html>