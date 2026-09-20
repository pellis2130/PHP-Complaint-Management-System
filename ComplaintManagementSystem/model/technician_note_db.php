<?php

require_once __DIR__ . '/database.php';
require_once __DIR__ . '/technician_note.php';

class TechnicianNoteDB
{
    // Get notes for a complaint
    public static function getNotesByComplaint($complaintId)
    {
        $db = new Database();
        $connection = $db->getConnection();

        $query = "SELECT * FROM technician_notes
                  WHERE ComplaintID = ?
                  ORDER BY DateCreated DESC";

        $stmt = mysqli_prepare($connection, $query);

        mysqli_stmt_bind_param(
            $stmt,
            "i",
            $complaintId
        );

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $notes = [];

        while ($row = mysqli_fetch_assoc($result)) {
            $notes[] = new TechnicianNote(
                $row['NoteID'],
                $row['ComplaintID'],
                $row['TechnicianID'],
                $row['NoteText'],
                $row['DateCreated']
            );
        }

        mysqli_stmt_close($stmt);

        return $notes;
    }

    // Add a technician note
    public static function addNote($note)
    {
        $db = new Database();
        $connection = $db->getConnection();

        $query = "INSERT INTO technician_notes
                  (ComplaintID, TechnicianID, NoteText)
                  VALUES (?, ?, ?)";

        $stmt = mysqli_prepare($connection, $query);

        $complaintId = $note->getComplaintId();
        $technicianId = $note->getTechnicianId();
        $noteText = $note->getNoteText();

        mysqli_stmt_bind_param(
            $stmt,
            "iis",
            $complaintId,
            $technicianId,
            $noteText
        );

        mysqli_stmt_execute($stmt);

        $noteId = mysqli_insert_id($connection);

        mysqli_stmt_close($stmt);

        return $noteId;
    }

    // Delete a technician note
    public static function deleteNote($noteId)
    {
        $db = new Database();
        $connection = $db->getConnection();

        $query = "DELETE FROM technician_notes
                  WHERE NoteID = ?";

        $stmt = mysqli_prepare($connection, $query);

        mysqli_stmt_bind_param(
            $stmt,
            "i",
            $noteId
        );

        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }
}

?>