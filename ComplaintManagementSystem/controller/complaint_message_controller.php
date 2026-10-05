<?php

session_start();

require_once __DIR__ . '/../model/complaint_db.php';
require_once __DIR__ . '/../model/complaint_message_db.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: ../view/login.php");
    exit;
}

$complaintId = (int) ($_POST['complaint_id'] ?? 0);
$messageText = trim($_POST['message_text'] ?? '');

if ($complaintId <= 0 || $messageText === '') {
    header("Location: ../view/login.php");
    exit;
}

$complaint = ComplaintDB::getComplaint($complaintId);

if (!$complaint) {
    header("Location: ../view/login.php");
    exit;
}

$userType = $_SESSION['user_type'] ?? '';

/*
 * Customer message
 */
if (
    $userType === 'Customer' &&
    isset($_SESSION['customer_id'])
) {
    $customerId = (int) $_SESSION['customer_id'];

    // Customer can only message about their own complaint.
    if ($complaint->getCustomerId() != $customerId) {
        header("Location: ../view/my_complaints.php");
        exit;
    }

    ComplaintMessageDB::addMessage(
        $complaintId,
        'Customer',
        $customerId,
        $messageText
    );

    header(
        "Location: ../view/my_complaints.php?message_sent=1#complaint-" .
        $complaintId
    );
    exit;
}

/*
 * Technician message
 */
if (
    $userType === 'Technician' &&
    isset($_SESSION['employee_id'])
) {
    $technicianId = (int) $_SESSION['employee_id'];

    // Technician can only message on complaints assigned to them.
    if ($complaint->getTechnicianId() != $technicianId) {
        header("Location: ../view/technician_complaints.php");
        exit;
    }

    ComplaintMessageDB::addMessage(
        $complaintId,
        'Technician',
        $technicianId,
        $messageText
    );

    header(
        "Location: ../view/technician_complaint.php?id=" .
        $complaintId .
        "&message_sent=1"
    );
    exit;
}

// No valid logged-in user.
header("Location: ../view/login.php");
exit;

?>