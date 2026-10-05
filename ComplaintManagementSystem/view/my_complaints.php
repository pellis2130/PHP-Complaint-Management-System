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
require_once __DIR__ . '/../model/technician_note_db.php';
require_once __DIR__ . '/../model/complaint_image_db.php';
require_once __DIR__ . '/../model/complaint_message_db.php';

$customerId = (int) $_SESSION['customer_id'];

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

                    $notes = TechnicianNoteDB::getNotesByComplaint(
                        $complaint->getComplaintId()
                    );

                    $images = ComplaintImageDB::getImagesByComplaint(
                        $complaint->getComplaintId()
                    );

                    $messages = ComplaintMessageDB::getMessagesByComplaint(
                        $complaint->getComplaintId()
                    );

                    ?>

                    <div
                        class="complaint"
                        id="complaint-<?php
                        echo $complaint->getComplaintId();
                        ?>"
                    >

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

                        <?php if (count($images) > 0) : ?>

                            <h4>Complaint Image</h4>

                            <?php foreach ($images as $image) : ?>

                                <img
                                    src="../uploads/complaints/<?php
                                    echo rawurlencode(
                                        $image['FileName']
                                    );
                                    ?>"
                                    alt="Complaint Image"
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

                        <h4>Technician Notes</h4>

                        <?php if (count($notes) === 0) : ?>

                            <p>
                                No technician notes have been added yet.
                            </p>

                        <?php else : ?>

                            <?php foreach ($notes as $note) : ?>

                                <p>
                                    <?php
                                    echo htmlspecialchars(
                                        $note->getNoteText()
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


                        <hr>

                        <h4>Complaint Messages</h4>

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
                                                === 'Customer'
                                            ) {
                                                echo 'You';
                                            } else {
                                                echo 'Technician';
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


                        <?php if (
                            $complaint->getStatus() === 'Open'
                        ) : ?>

                            <h4>Send Message to Technician</h4>

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

                                <label
                                    for="message_text_<?php
                                    echo $complaint->getComplaintId();
                                    ?>"
                                >
                                    Message
                                </label>

                                <textarea
                                    id="message_text_<?php
                                    echo $complaint->getComplaintId();
                                    ?>"
                                    name="message_text"
                                    rows="4"
                                    maxlength="2000"
                                    required
                                ></textarea>

                                <input
                                    type="submit"
                                    value="Send Message"
                                >

                            </form>

                        <?php endif; ?>

                    </div>

                <?php endforeach; ?>

            <?php endif; ?>

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