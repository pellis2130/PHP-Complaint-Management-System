<?php

require_once __DIR__ . '/database.php';
require_once __DIR__ . '/complaint.php';

class ComplaintDB
{
    // Get all complaints
    public static function getComplaints()
    {
        $db = new Database();
        $connection = $db->getConnection();

        $query = "SELECT * FROM complaints
                  ORDER BY DateCreated DESC";

        $result = mysqli_query($connection, $query);

        $complaints = [];

        while ($row = mysqli_fetch_assoc($result)) {
            $complaints[] = self::makeComplaint($row);
        }

        return $complaints;
    }

    // Get one complaint
    public static function getComplaint($complaintId)
    {
        $db = new Database();
        $connection = $db->getConnection();

        $query = "SELECT * FROM complaints
                  WHERE ComplaintID = ?";

        $stmt = mysqli_prepare($connection, $query);

        mysqli_stmt_bind_param(
            $stmt,
            "i",
            $complaintId
        );

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);
        $row = mysqli_fetch_assoc($result);

        mysqli_stmt_close($stmt);

        if ($row) {
            return self::makeComplaint($row);
        }

        return null;
    }

    // Get complaints for one customer
    public static function getComplaintsByCustomer($customerId)
    {
        $db = new Database();
        $connection = $db->getConnection();

        $query = "SELECT * FROM complaints
                  WHERE CustomerID = ?
                  ORDER BY DateCreated DESC";

        $stmt = mysqli_prepare($connection, $query);

        mysqli_stmt_bind_param(
            $stmt,
            "i",
            $customerId
        );

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $complaints = [];

        while ($row = mysqli_fetch_assoc($result)) {
            $complaints[] = self::makeComplaint($row);
        }

        mysqli_stmt_close($stmt);

        return $complaints;
    }

    // Get complaints assigned to a technician
    public static function getComplaintsByTechnician($technicianId)
    {
        $db = new Database();
        $connection = $db->getConnection();

        $query = "SELECT * FROM complaints
                  WHERE TechnicianID = ?
                  ORDER BY DateCreated DESC";

        $stmt = mysqli_prepare($connection, $query);

        mysqli_stmt_bind_param(
            $stmt,
            "i",
            $technicianId
        );

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $complaints = [];

        while ($row = mysqli_fetch_assoc($result)) {
            $complaints[] = self::makeComplaint($row);
        }

        mysqli_stmt_close($stmt);

        return $complaints;
    }

    // Add a new complaint
    public static function addComplaint($complaint)
    {
        $db = new Database();
        $connection = $db->getConnection();

        $query = "INSERT INTO complaints
                  (CustomerID, ProductID, ComplaintTypeID, Description)
                  VALUES (?, ?, ?, ?)";

        $stmt = mysqli_prepare($connection, $query);

        $customerId = $complaint->getCustomerId();
        $productId = $complaint->getProductId();
        $complaintTypeId = $complaint->getComplaintTypeId();
        $description = $complaint->getDescription();

        mysqli_stmt_bind_param(
            $stmt,
            "iiis",
            $customerId,
            $productId,
            $complaintTypeId,
            $description
        );

        mysqli_stmt_execute($stmt);

        $complaintId = mysqli_insert_id($connection);

        mysqli_stmt_close($stmt);

        return $complaintId;
    }

    // Assign complaint to a technician
    public static function assignTechnician($complaintId, $technicianId)
    {
        $db = new Database();
        $connection = $db->getConnection();

        $query = "UPDATE complaints
                  SET TechnicianID = ?,
                      DateUpdated = CURRENT_TIMESTAMP
                  WHERE ComplaintID = ?";

        $stmt = mysqli_prepare($connection, $query);

        mysqli_stmt_bind_param(
            $stmt,
            "ii",
            $technicianId,
            $complaintId
        );

        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }

    // Update a complaint
    public static function updateComplaint($complaint)
    {
        $db = new Database();
        $connection = $db->getConnection();

        $query = "UPDATE complaints
                  SET ProductID = ?,
                      ComplaintTypeID = ?,
                      TechnicianID = ?,
                      Description = ?,
                      Status = ?,
                      ResolutionDate = ?,
                      ResolutionNotes = ?,
                      DateUpdated = CURRENT_TIMESTAMP
                  WHERE ComplaintID = ?";

        $stmt = mysqli_prepare($connection, $query);

        $productId = $complaint->getProductId();
        $complaintTypeId = $complaint->getComplaintTypeId();
        $technicianId = $complaint->getTechnicianId();
        $description = $complaint->getDescription();
        $status = $complaint->getStatus();
        $resolutionDate = $complaint->getResolutionDate();
        $resolutionNotes = $complaint->getResolutionNotes();
        $complaintId = $complaint->getComplaintId();

        mysqli_stmt_bind_param(
            $stmt,
            "iiissssi",
            $productId,
            $complaintTypeId,
            $technicianId,
            $description,
            $status,
            $resolutionDate,
            $resolutionNotes,
            $complaintId
        );

        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }

    // Mark complaint as closed
    public static function closeComplaint($complaintId, $resolutionNotes)
    {
        $db = new Database();
        $connection = $db->getConnection();

        $query = "UPDATE complaints
                  SET Status = 'Closed',
                      ResolutionDate = CURRENT_TIMESTAMP,
                      ResolutionNotes = ?,
                      DateUpdated = CURRENT_TIMESTAMP
                  WHERE ComplaintID = ?";

        $stmt = mysqli_prepare($connection, $query);

        mysqli_stmt_bind_param(
            $stmt,
            "si",
            $resolutionNotes,
            $complaintId
        );

        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }

    // Turn a database row into a Complaint object
    private static function makeComplaint($row)
    {
        return new Complaint(
            $row['ComplaintID'],
            $row['CustomerID'],
            $row['ProductID'],
            $row['ComplaintTypeID'],
            $row['TechnicianID'],
            $row['Description'],
            $row['Status'],
            $row['DateCreated'],
            $row['ResolutionDate'],
            $row['ResolutionNotes'],
            $row['DateUpdated']
        );
    }
}

?>