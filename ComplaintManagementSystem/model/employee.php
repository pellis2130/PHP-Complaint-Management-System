<?php

class Employee
{
    private $employeeId;
    private $userId;
    private $firstName;
    private $lastName;
    private $email;
    private $phoneExtension;
    private $password;
    private $level;

    public function __construct(
        $employeeId = null,
        $userId = '',
        $firstName = '',
        $lastName = '',
        $email = '',
        $phoneExtension = '',
        $password = '',
        $level = ''
    ) {
        $this->employeeId = $employeeId;
        $this->userId = $userId;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->email = $email;
        $this->phoneExtension = $phoneExtension;
        $this->password = $password;
        $this->level = $level;
    }

    public function getEmployeeId()
    {
        return $this->employeeId;
    }

    public function setEmployeeId($employeeId)
    {
        $this->employeeId = $employeeId;
    }

    public function getUserId()
    {
        return $this->userId;
    }

    public function setUserId($userId)
    {
        $this->userId = $userId;
    }

    public function getFirstName()
    {
        return $this->firstName;
    }

    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
    }

    public function getLastName()
    {
        return $this->lastName;
    }

    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function getPhoneExtension()
    {
        return $this->phoneExtension;
    }

    public function setPhoneExtension($phoneExtension)
    {
        $this->phoneExtension = $phoneExtension;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setPassword($password)
    {
        $this->password = $password;
    }

    public function getLevel()
    {
        return $this->level;
    }

    public function setLevel($level)
    {
        $this->level = $level;
    }
}
?>