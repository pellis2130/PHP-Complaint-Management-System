<?php

class Customer
{
    private $customerId;
    private $email;
    private $firstName;
    private $lastName;
    private $streetAddress;
    private $city;
    private $state;
    private $zipCode;
    private $phoneNumber;
    private $password;

    public function __construct(
        $customerId = null,
        $email = "",
        $firstName = "",
        $lastName = "",
        $streetAddress = "",
        $city = "",
        $state = "",
        $zipCode = "",
        $phoneNumber = "",
        $password = ""
    ) {
        $this->customerId = $customerId;
        $this->email = $email;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->streetAddress = $streetAddress;
        $this->city = $city;
        $this->state = $state;
        $this->zipCode = $zipCode;
        $this->phoneNumber = $phoneNumber;
        $this->password = $password;
    }

    public function getCustomerId()
    {
        return $this->customerId;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getFirstName()
    {
        return $this->firstName;
    }

    public function getLastName()
    {
        return $this->lastName;
    }

    public function getStreetAddress()
    {
        return $this->streetAddress;
    }

    public function getCity()
    {
        return $this->city;
    }

    public function getState()
    {
        return $this->state;
    }

    public function getZipCode()
    {
        return $this->zipCode;
    }

    public function getPhoneNumber()
    {
        return $this->phoneNumber;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
    }

    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
    }

    public function setStreetAddress($streetAddress)
    {
        $this->streetAddress = $streetAddress;
    }

    public function setCity($city)
    {
        $this->city = $city;
    }

    public function setState($state)
    {
        $this->state = $state;
    }

    public function setZipCode($zipCode)
    {
        $this->zipCode = $zipCode;
    }

    public function setPhoneNumber($phoneNumber)
    {
        $this->phoneNumber = $phoneNumber;
    }

    public function setPassword($password)
    {
        $this->password = $password;
    }
}