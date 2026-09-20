<?php

session_start();

require_once __DIR__ . '/../model/complaint_type.php';
require_once __DIR__ . '/../model/complaint_type_db.php';

if (
    !isset($_SESSION['employee_id']) ||
    ($_SESSION['user_type'] ?? '') !== 'Administrator'
) {
    header("Location: ../view/login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $action = $_POST['action'] ?? '';

    // Add a complaint type
    if ($action === 'Add') {

        $typeName = trim($_POST['type_name'] ?? '');
        $description = trim($_POST['description'] ?? '');

        if ($typeName === '' || $description === '') {
            header(
                "Location: ../view/admin_complaint_types.php?error=1"
            );
            exit;
        }

        $complaintType = new ComplaintType(
            null,
            $typeName,
            $description,
            1
        );

        ComplaintTypeDB::addComplaintType(
            $complaintType
        );

        header(
            "Location: ../view/admin_complaint_types.php?added=1"
        );
        exit;
    }

    // Remove a complaint type
    if ($action === 'Remove') {

        $complaintTypeId = (int) (
            $_POST['complaint_type_id'] ?? 0
        );

        if ($complaintTypeId <= 0) {
            header(
                "Location: ../view/admin_complaint_types.php?error=1"
            );
            exit;
        }

        ComplaintTypeDB::deleteComplaintType(
            $complaintTypeId
        );

        header(
            "Location: ../view/admin_complaint_types.php?deleted=1"
        );
        exit;
    }
}

header("Location: ../view/admin_complaint_types.php");
exit;

?>