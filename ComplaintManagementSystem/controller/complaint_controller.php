<?php

session_start();

require_once __DIR__ . '/../model/complaint.php';
require_once __DIR__ . '/../model/complaint_db.php';

if (
    !isset($_SESSION['customer_id']) ||
    ($_SESSION['user_type'] ?? '') !== 'Customer'
) {
    header("Location: ../view/login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $productId = (int) ($_POST['product_id'] ?? 0);
    $complaintTypeId = (int) ($_POST['complaint_type_id'] ?? 0);
    $description = trim($_POST['description'] ?? '');

    if (
        $productId <= 0 ||
        $complaintTypeId <= 0 ||
        $description === ''
    ) {
        header("Location: ../view/new_complaint.php?error=1");
        exit;
    }

    $customerId = $_SESSION['customer_id'];

    $complaint = new Complaint(
        null,
        $customerId,
        $productId,
        $complaintTypeId,
        null,
        $description,
        'Open'
    );

    ComplaintDB::addComplaint($complaint);

    header("Location: ../view/new_complaint.php?success=1");
    exit;
}

header("Location: ../view/customer_home.php");
exit;

?>