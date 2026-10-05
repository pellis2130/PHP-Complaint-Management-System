<?php

session_start();

require_once __DIR__ . '/../model/complaint_type.php';
require_once __DIR__ . '/../model/complaint_type_db.php';
require_once __DIR__ . '/../includes/validation.php';

if (
    !isset($_SESSION['employee_id']) ||
    ($_SESSION['user_type'] ?? '') !== 'Administrator'
) {
    header("Location: ../view/login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header(
        "Location: ../view/admin_complaint_types.php"
    );
    exit;
}

$action = $_POST['action'] ?? '';


/*
 * Add complaint type
 */
if ($action === 'Add') {

    $typeName = trim(
        $_POST['type_name'] ?? ''
    );

    $description = trim(
        $_POST['description'] ?? ''
    );

    if (
        !validateRequired($typeName) ||
        !validateRequired($description)
    ) {
        header(
            "Location: ../view/admin_complaint_types.php?" .
            "error=required"
        );
        exit;
    }

    if (!validateLength($typeName, 1, 100)) {
        header(
            "Location: ../view/admin_complaint_types.php?" .
            "error=name_length"
        );
        exit;
    }

    if (!validateLength($description, 1, 2000)) {
        header(
            "Location: ../view/admin_complaint_types.php?" .
            "error=description_length"
        );
        exit;
    }

    $complaintType = new ComplaintType(
        null,
        $typeName,
        $description,
        1
    );

    $success =
        ComplaintTypeDB::addComplaintType(
            $complaintType
        );

    if (!$success) {
        header(
            "Location: ../view/admin_complaint_types.php?" .
            "error=database"
        );
        exit;
    }

    header(
        "Location: ../view/admin_complaint_types.php?" .
        "added=1"
    );
    exit;
}


/*
 * Remove/deactivate complaint type
 */
if ($action === 'Remove') {

    $complaintTypeId = (int) (
        $_POST['complaint_type_id'] ?? 0
    );

    if ($complaintTypeId <= 0) {
        header(
            "Location: ../view/admin_complaint_types.php?" .
            "error=invalid"
        );
        exit;
    }

    $complaintType =
        ComplaintTypeDB::getComplaintType(
            $complaintTypeId
        );

    if (!$complaintType) {
        header(
            "Location: ../view/admin_complaint_types.php?" .
            "error=invalid"
        );
        exit;
    }

    $success =
        ComplaintTypeDB::deleteComplaintType(
            $complaintTypeId
        );

    if (!$success) {
        header(
            "Location: ../view/admin_complaint_types.php?" .
            "error=database"
        );
        exit;
    }

    header(
        "Location: ../view/admin_complaint_types.php?" .
        "removed=1"
    );
    exit;
}


/*
 * Reactivate complaint type
 */
if ($action === 'Activate') {

    $complaintTypeId = (int) (
        $_POST['complaint_type_id'] ?? 0
    );

    if ($complaintTypeId <= 0) {
        header(
            "Location: ../view/admin_complaint_types.php?" .
            "error=invalid"
        );
        exit;
    }

    $success =
        ComplaintTypeDB::activateComplaintType(
            $complaintTypeId
        );

    if (!$success) {
        header(
            "Location: ../view/admin_complaint_types.php?" .
            "error=database"
        );
        exit;
    }

    header(
        "Location: ../view/admin_complaint_types.php?" .
        "activated=1"
    );
    exit;
}


header(
    "Location: ../view/admin_complaint_types.php?" .
    "error=invalid"
);
exit;

?>