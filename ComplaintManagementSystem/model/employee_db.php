<?php

require_once __DIR__ . '/database.php';
require_once __DIR__ . '/employee.php';

class EmployeeDB
{
    // Get all employees
    public static function getEmployees()
    {
        $db = new Database();
        $connection = $db->getConnection();

        $query = "SELECT * FROM employees
                  ORDER BY LastName, FirstName";

        $result = mysqli_query($connection, $query);

        $employees = [];

        while ($row = mysqli_fetch_assoc($result)) {
            $employees[] = self::makeEmployee($row);
        }

        return $employees;
    }

    // Get one employee by ID
    public static function getEmployee($employeeId)
    {
        $db = new Database();
        $connection = $db->getConnection();

        $query = "SELECT * FROM employees
                  WHERE EmployeeID = ?";

        $stmt = mysqli_prepare($connection, $query);

        mysqli_stmt_bind_param(
            $stmt,
            "i",
            $employeeId
        );

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);
        $row = mysqli_fetch_assoc($result);

        mysqli_stmt_close($stmt);

        if ($row) {
            return self::makeEmployee($row);
        }

        return null;
    }

    // Get employee by User ID
    public static function getEmployeeByUserId($userId)
    {
        $db = new Database();
        $connection = $db->getConnection();

        $query = "SELECT * FROM employees
                  WHERE UserID = ?";

        $stmt = mysqli_prepare($connection, $query);

        mysqli_stmt_bind_param(
            $stmt,
            "s",
            $userId
        );

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);
        $row = mysqli_fetch_assoc($result);

        mysqli_stmt_close($stmt);

        if ($row) {
            return self::makeEmployee($row);
        }

        return null;
    }

    // Get employee by email
    public static function getEmployeeByEmail($email)
    {
        $db = new Database();
        $connection = $db->getConnection();

        $query = "SELECT * FROM employees
                  WHERE Email = ?";

        $stmt = mysqli_prepare($connection, $query);

        mysqli_stmt_bind_param(
            $stmt,
            "s",
            $email
        );

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);
        $row = mysqli_fetch_assoc($result);

        mysqli_stmt_close($stmt);

        if ($row) {
            return self::makeEmployee($row);
        }

        return null;
    }

    // Add employee
    public static function addEmployee($employee)
    {
        $db = new Database();
        $connection = $db->getConnection();

        $query = "INSERT INTO employees
                  (UserID, FirstName, LastName, Email,
                   PhoneExtension, Password, Level)
                  VALUES (?, ?, ?, ?, ?, ?, ?)";

        $stmt = mysqli_prepare($connection, $query);

        $userId = $employee->getUserId();
        $firstName = $employee->getFirstName();
        $lastName = $employee->getLastName();
        $email = $employee->getEmail();
        $phoneExtension = $employee->getPhoneExtension();
        $password = $employee->getPassword();
        $level = $employee->getLevel();

        mysqli_stmt_bind_param(
            $stmt,
            "sssssss",
            $userId,
            $firstName,
            $lastName,
            $email,
            $phoneExtension,
            $password,
            $level
        );

        mysqli_stmt_execute($stmt);

        $employeeId = mysqli_insert_id($connection);

        mysqli_stmt_close($stmt);

        return $employeeId;
    }

    // Update employee
    public static function updateEmployee($employee)
    {
        $db = new Database();
        $connection = $db->getConnection();

        $query = "UPDATE employees
                  SET UserID = ?,
                      FirstName = ?,
                      LastName = ?,
                      Email = ?,
                      PhoneExtension = ?,
                      Level = ?
                  WHERE EmployeeID = ?";

        $stmt = mysqli_prepare($connection, $query);

        $userId = $employee->getUserId();
        $firstName = $employee->getFirstName();
        $lastName = $employee->getLastName();
        $email = $employee->getEmail();
        $phoneExtension = $employee->getPhoneExtension();
        $level = $employee->getLevel();
        $employeeId = $employee->getEmployeeId();

        mysqli_stmt_bind_param(
            $stmt,
            "ssssssi",
            $userId,
            $firstName,
            $lastName,
            $email,
            $phoneExtension,
            $level,
            $employeeId
        );

        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }

    // Delete employee
    public static function updatePassword($employeeId, $password)
{
    $db = new Database();
    $connection = $db->getConnection();

    $query = "UPDATE employees
              SET Password = ?
              WHERE EmployeeID = ?";

    $stmt = mysqli_prepare($connection, $query);

    mysqli_stmt_bind_param(
        $stmt,
        "si",
        $password,
        $employeeId
    );

    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}

public static function deleteEmployee($employeeId)
{
    $db = new Database();
    $connection = $db->getConnection();

    $query = "DELETE FROM employees
              WHERE EmployeeID = ?";

    $stmt = mysqli_prepare($connection, $query);

    mysqli_stmt_bind_param($stmt, "i", $employeeId);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}

private static function makeEmployee($row)
{
    return new Employee(
        $row['EmployeeID'],
        $row['UserID'],
        $row['FirstName'],
        $row['LastName'],
        $row['Email'],
        $row['PhoneExtension'],
        $row['Password'],
        $row['Level']
    );
}

}
?>