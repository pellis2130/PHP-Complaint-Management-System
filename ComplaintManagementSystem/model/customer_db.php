<?php

require_once __DIR__ . '/database.php';
require_once __DIR__ . '/customer.php';

class CustomerDB
{
    // Get all customers
    public static function getCustomers()
    {
        $db = new Database();
        $connection = $db->getConnection();

        $query = "SELECT * FROM customers
                  ORDER BY LastName, FirstName";

        $result = mysqli_query($connection, $query);

        $customers = [];

        while ($row = mysqli_fetch_assoc($result)) {
            $customers[] = self::makeCustomer($row);
        }

        return $customers;
    }

    // Get one customer by ID
    public static function getCustomer($customerId)
    {
        $db = new Database();
        $connection = $db->getConnection();

        $query = "SELECT * FROM customers
                  WHERE CustomerID = ?";

        $stmt = mysqli_prepare($connection, $query);

        mysqli_stmt_bind_param(
            $stmt,
            "i",
            $customerId
        );

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);
        $row = mysqli_fetch_assoc($result);

        mysqli_stmt_close($stmt);

        if ($row) {
            return self::makeCustomer($row);
        }

        return null;
    }

    // Get one customer by email
    public static function getCustomerByEmail($email)
    {
        $db = new Database();
        $connection = $db->getConnection();

        $query = "SELECT * FROM customers
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
            return self::makeCustomer($row);
        }

        return null;
    }

    // Add a new customer
    public static function addCustomer($customer)
    {
        $db = new Database();
        $connection = $db->getConnection();

        $query = "INSERT INTO customers
                  (Email, FirstName, LastName, StreetAddress,
                   City, State, ZipCode, PhoneNumber, Password)
                  VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = mysqli_prepare($connection, $query);

        $email = $customer->getEmail();
        $firstName = $customer->getFirstName();
        $lastName = $customer->getLastName();
        $streetAddress = $customer->getStreetAddress();
        $city = $customer->getCity();
        $state = $customer->getState();
        $zipCode = $customer->getZipCode();
        $phoneNumber = $customer->getPhoneNumber();
        $password = $customer->getPassword();

        mysqli_stmt_bind_param(
            $stmt,
            "sssssssss",
            $email,
            $firstName,
            $lastName,
            $streetAddress,
            $city,
            $state,
            $zipCode,
            $phoneNumber,
            $password
        );

        mysqli_stmt_execute($stmt);

        $customerId = mysqli_insert_id($connection);

        mysqli_stmt_close($stmt);

        return $customerId;
    }

    // Update customer information
    public static function updateCustomer($customer)
    {
        $db = new Database();
        $connection = $db->getConnection();

        $query = "UPDATE customers
                  SET Email = ?,
                      FirstName = ?,
                      LastName = ?,
                      StreetAddress = ?,
                      City = ?,
                      State = ?,
                      ZipCode = ?,
                      PhoneNumber = ?
                  WHERE CustomerID = ?";

        $stmt = mysqli_prepare($connection, $query);

        $email = $customer->getEmail();
        $firstName = $customer->getFirstName();
        $lastName = $customer->getLastName();
        $streetAddress = $customer->getStreetAddress();
        $city = $customer->getCity();
        $state = $customer->getState();
        $zipCode = $customer->getZipCode();
        $phoneNumber = $customer->getPhoneNumber();
        $customerId = $customer->getCustomerId();

        mysqli_stmt_bind_param(
            $stmt,
            "ssssssssi",
            $email,
            $firstName,
            $lastName,
            $streetAddress,
            $city,
            $state,
            $zipCode,
            $phoneNumber,
            $customerId
        );

        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }

    // Delete customer
    public static function deleteCustomer($customerId)
    {
        $db = new Database();
        $connection = $db->getConnection();

        $query = "DELETE FROM customers
                  WHERE CustomerID = ?";

        $stmt = mysqli_prepare($connection, $query);

        mysqli_stmt_bind_param(
            $stmt,
            "i",
            $customerId
        );

        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }

    // Turn database row into Customer object
    private static function makeCustomer($row)
    {
        return new Customer(
            $row['CustomerID'],
            $row['Email'],
            $row['FirstName'],
            $row['LastName'],
            $row['StreetAddress'],
            $row['City'],
            $row['State'],
            $row['ZipCode'],
            $row['PhoneNumber'],
            $row['Password']
        );
    }
}

?>