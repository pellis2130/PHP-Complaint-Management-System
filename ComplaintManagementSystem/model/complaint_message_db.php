<?php

require_once __DIR__ . '/database.php';

class ComplaintMessageDB
{
    // Get all messages for one complaint.
    public static function getMessagesByComplaint($complaintId)
    {
        $db = new Database();
        $connection = $db->getConnection();

        $query = "SELECT *
                  FROM complaint_messages
                  WHERE ComplaintID = ?
                  ORDER BY DateCreated ASC, MessageID ASC";

        $stmt = mysqli_prepare($connection, $query);

        mysqli_stmt_bind_param(
            $stmt,
            "i",
            $complaintId
        );

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $messages = [];

        while ($row = mysqli_fetch_assoc($result)) {
            $messages[] = $row;
        }

        mysqli_stmt_close($stmt);

        return $messages;
    }

    // Add a message to a complaint.
    public static function addMessage(
        $complaintId,
        $senderType,
        $senderId,
        $messageText
    ) {
        $db = new Database();
        $connection = $db->getConnection();

        $query = "INSERT INTO complaint_messages
                  (
                      ComplaintID,
                      SenderType,
                      SenderID,
                      MessageText
                  )
                  VALUES (?, ?, ?, ?)";

        $stmt = mysqli_prepare($connection, $query);

        mysqli_stmt_bind_param(
            $stmt,
            "isis",
            $complaintId,
            $senderType,
            $senderId,
            $messageText
        );

        $success = mysqli_stmt_execute($stmt);

        mysqli_stmt_close($stmt);

        return $success;
    }
}

?>