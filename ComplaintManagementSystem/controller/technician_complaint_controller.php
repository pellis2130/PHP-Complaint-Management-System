<?php

session_start();

require_once __DIR__ . '/../model/complaint_db.php';
require_once __DIR__ . '/../model/technician_note.php';
require_once __DIR__ . '/../model/technician_note_db.php';

if (
    !isset($_SESSION['employee_id']) ||
    ($_SESSION['user_type'] ?? '') !== 'Technician'
) {
    header("Location: ../view/login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $complaintId = (int) ($_POST['complaint_id'] ?? 0);
    $action = $_POST['action'] ?? '';

    $technicianId = (int) $_SESSION['employee_id'];

    $complaint = ComplaintDB::getComplaint($complaintId);

    // Make sure this complaint belongs to this technician
    if (
        !$complaint ||
        $complaint->getTechnicianId() != $technicianId
    ) {
        header("Location: ../view/technician_complaints.php");
        exit;
    }

    if ($action === 'Add Note') {

        $noteText = trim($_POST['note_text'] ?? '');

        if ($noteText === '') {
            header(
                "Location: ../view/technician_complaint.php?id=" .
                $complaintId
            );
            exit;
        }

        $note = new TechnicianNote(
            null,
            $complaintId,
            $technicianId,
            $noteText
        );

        TechnicianNoteDB::addNote($note);

        header(
            "Location: ../view/technician_complaint.php?id=" .
            $complaintId .
            "&note=1"
        );
        exit;
    }

    if ($action === 'Mark Resolved') {

        $resolutionNotes = trim(
            $_POST['resolution_notes'] ?? ''
        );

        if ($resolutionNotes === '') {
            header(
                "Location: ../view/technician_complaint.php?id=" .
                $complaintId
            );
            exit;
        }

        ComplaintDB::closeComplaint(
            $complaintId,
            $resolutionNotes
        );

        header(
            "Location: ../view/technician_complaint.php?id=" .
            $complaintId .
            "&closed=1"
        );
        exit;
    }
}

header("Location: ../view/technician_complaints.php");
exit;

?>