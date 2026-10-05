<?php

require_once __DIR__ . '/database.php';

class ComplaintImageDB
{
    // Add an uploaded image to a complaint.
    public static function addImage($complaintId, $fileName)
    {
        $db = new Database();
        $connection = $db->getConnection();

        $query = "INSERT INTO complaint_images
                  (ComplaintID, FileName)
                  VALUES (?, ?)";

        $stmt = mysqli_prepare($connection, $query);

        mysqli_stmt_bind_param(
            $stmt,
            "is",
            $complaintId,
            $fileName
        );

        $success = mysqli_stmt_execute($stmt);

        mysqli_stmt_close($stmt);

        return $success;
    }

    // Get all images for one complaint.
    public static function getImagesByComplaint($complaintId)
    {
        $db = new Database();
        $connection = $db->getConnection();

        $query = "SELECT *
                  FROM complaint_images
                  WHERE ComplaintID = ?
                  ORDER BY UploadDate ASC";

        $stmt = mysqli_prepare($connection, $query);

        mysqli_stmt_bind_param(
            $stmt,
            "i",
            $complaintId
        );

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $images = [];

        while ($row = mysqli_fetch_assoc($result)) {
            $images[] = $row;
        }

        mysqli_stmt_close($stmt);

        return $images;
    }
}

?>