<?php

class Database
{
    private $host = "localhost";
    private $database = "complaint_management";
    private $username = "complaint_user";
    private $password = "Complaint2026!";

    private $connection;

    public function __construct()
    {
        mysqli_report(MYSQLI_REPORT_OFF);

        $this->connection = mysqli_connect(
            $this->host,
            $this->username,
            $this->password,
            $this->database
        );
    }

    public function getConnection()
    {
        return $this->connection;
    }

    public function getError()
    {
        if (!$this->connection) {
            return mysqli_connect_error();
        }

        return "";
    }

    public function __destruct()
    {
        if ($this->connection) {
            mysqli_close($this->connection);
        }
    }
}