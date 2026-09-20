<?php

session_start();

require_once __DIR__ . '/../model/complaint_db.php';

if (
    !isset($_SESSION['employee_id']) ||
    ($_SESSION['user_type'] ?? '') !== 'Administrator'
) {
    header("Location: ../view/login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $complaintId = (int) ($_POST['complaint_id'] ?? 0);
    $technicianId = (int) ($_POST['technician_id'] ?? 0);

    if ($complaintId <= 0 || $technicianId <= 0) {
        header("Location: ../view/admin_complaints.php?error=1");
        exit;
    }

    ComplaintDB::assignTechnician(
        $complaintId,
        $technicianId
    );

    header("Location: ../view/admin_complaints.php?assigned=1");
    exit;
}

header("Location: ../view/admin_complaints.php");
exit;

?>