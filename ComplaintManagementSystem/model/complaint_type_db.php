<?php

require_once __DIR__ . '/database.php';
require_once __DIR__ . '/complaint_type.php';

class ComplaintTypeDB
{
    // Get active complaint types
    public static function getComplaintTypes()
    {
        $db = new Database();
        $connection = $db->getConnection();

        $query = "SELECT *
                  FROM complaint_types
                  WHERE Active = 1
                  ORDER BY TypeName";

        $result = mysqli_query(
            $connection,
            $query
        );

        $complaintTypes = [];

        while ($row = mysqli_fetch_assoc($result)) {

            $complaintTypes[] = new ComplaintType(
                $row['ComplaintTypeID'],
                $row['TypeName'],
                $row['Description'],
                $row['Active']
            );
        }

        return $complaintTypes;
    }


    // Get all complaint types for admin
    public static function getAllComplaintTypes()
    {
        $db = new Database();
        $connection = $db->getConnection();

        $query = "SELECT *
                  FROM complaint_types
                  ORDER BY Active DESC, TypeName";

        $result = mysqli_query(
            $connection,
            $query
        );

        $complaintTypes = [];

        while ($row = mysqli_fetch_assoc($result)) {

            $complaintTypes[] = new ComplaintType(
                $row['ComplaintTypeID'],
                $row['TypeName'],
                $row['Description'],
                $row['Active']
            );
        }

        return $complaintTypes;
    }


    // Get one complaint type
    public static function getComplaintType(
        $complaintTypeId
    ) {
        $db = new Database();
        $connection = $db->getConnection();

        $query = "SELECT *
                  FROM complaint_types
                  WHERE ComplaintTypeID = ?";

        $stmt = mysqli_prepare(
            $connection,
            $query
        );

        mysqli_stmt_bind_param(
            $stmt,
            "i",
            $complaintTypeId
        );

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);
        $row = mysqli_fetch_assoc($result);

        mysqli_stmt_close($stmt);

        if ($row) {

            return new ComplaintType(
                $row['ComplaintTypeID'],
                $row['TypeName'],
                $row['Description'],
                $row['Active']
            );
        }

        return null;
    }


    // Add complaint type
    public static function addComplaintType(
        $complaintType
    ) {
        $db = new Database();
        $connection = $db->getConnection();

        $query = "INSERT INTO complaint_types
                  (
                      TypeName,
                      Description,
                      Active
                  )
                  VALUES (?, ?, ?)";

        $stmt = mysqli_prepare(
            $connection,
            $query
        );

        $typeName =
            $complaintType->getTypeName();

        $description =
            $complaintType->getDescription();

        $active =
            $complaintType->getActive();

        mysqli_stmt_bind_param(
            $stmt,
            "ssi",
            $typeName,
            $description,
            $active
        );

        $success = mysqli_stmt_execute($stmt);

        mysqli_stmt_close($stmt);

        return $success;
    }


    // Update complaint type
    public static function updateComplaintType(
        $complaintType
    ) {
        $db = new Database();
        $connection = $db->getConnection();

        $query = "UPDATE complaint_types
                  SET TypeName = ?,
                      Description = ?,
                      Active = ?
                  WHERE ComplaintTypeID = ?";

        $stmt = mysqli_prepare(
            $connection,
            $query
        );

        $typeName =
            $complaintType->getTypeName();

        $description =
            $complaintType->getDescription();

        $active =
            $complaintType->getActive();

        $complaintTypeId =
            $complaintType->getComplaintTypeId();

        mysqli_stmt_bind_param(
            $stmt,
            "ssii",
            $typeName,
            $description,
            $active,
            $complaintTypeId
        );

        $success = mysqli_stmt_execute($stmt);

        mysqli_stmt_close($stmt);

        return $success;
    }


    // Deactivate complaint type
    public static function deleteComplaintType(
        $complaintTypeId
    ) {
        $db = new Database();
        $connection = $db->getConnection();

        $query = "UPDATE complaint_types
                  SET Active = 0
                  WHERE ComplaintTypeID = ?";

        $stmt = mysqli_prepare(
            $connection,
            $query
        );

        mysqli_stmt_bind_param(
            $stmt,
            "i",
            $complaintTypeId
        );

        $success = mysqli_stmt_execute($stmt);

        mysqli_stmt_close($stmt);

        return $success;
    }


    // Reactivate complaint type
    public static function activateComplaintType(
        $complaintTypeId
    ) {
        $db = new Database();
        $connection = $db->getConnection();

        $query = "UPDATE complaint_types
                  SET Active = 1
                  WHERE ComplaintTypeID = ?";

        $stmt = mysqli_prepare(
            $connection,
            $query
        );

        mysqli_stmt_bind_param(
            $stmt,
            "i",
            $complaintTypeId
        );

        $success = mysqli_stmt_execute($stmt);

        mysqli_stmt_close($stmt);

        return $success;
    }
}

?>