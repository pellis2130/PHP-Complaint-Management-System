<?php

session_start();

require_once __DIR__ . '/../model/complaint_db.php';
require_once __DIR__ . '/../model/technician_note.php';
require_once __DIR__ . '/../model/technician_note_db.php';
require_once __DIR__ . '/../includes/validation.php';

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

    /*
     * Make sure the complaint exists
     * and belongs to this technician.
     */
    $complaint = ComplaintDB::getComplaint(
        $complaintId
    );

    if (
        !$complaint ||
        $complaint->getTechnicianId() != $technicianId
    ) {
        header(
            "Location: ../view/technician_complaints.php"
        );
        exit;
    }


    /*
     * Add technician note.
     */
    if ($action === 'Add Note') {

        $noteText = trim(
            $_POST['note_text'] ?? ''
        );

        /*
         * Technician notes are required.
         */
        if (!validateRequired($noteText)) {
            header(
                "Location: ../view/technician_complaint.php?id=" .
                $complaintId .
                "&error=note_required"
            );
            exit;
        }

        /*
         * NoteText is stored as TEXT.
         * Limit notes to 2,000 characters.
         */
        if (!validateLength($noteText, 1, 2000)) {
            header(
                "Location: ../view/technician_complaint.php?id=" .
                $complaintId .
                "&error=note_length"
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


    /*
     * Mark complaint as resolved.
     */
    if ($action === 'Mark Resolved') {

        $resolutionNotes = trim(
            $_POST['resolution_notes'] ?? ''
        );

        /*
         * Resolution notes are required.
         */
        if (!validateRequired($resolutionNotes)) {
            header(
                "Location: ../view/technician_complaint.php?id=" .
                $complaintId .
                "&error=resolution_required"
            );
            exit;
        }

        /*
         * ResolutionNotes is stored as TEXT.
         * Limit notes to 2,000 characters.
         */
        if (
            !validateLength(
                $resolutionNotes,
                1,
                2000
            )
        ) {
            header(
                "Location: ../view/technician_complaint.php?id=" .
                $complaintId .
                "&error=resolution_length"
            );
            exit;
        }

        /*
         * This method also saves the
         * resolution date automatically.
         */
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

header(
    "Location: ../view/technician_complaints.php"
);
exit;

?>