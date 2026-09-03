<?php

function validateRequired($value)
{
    return strlen(trim($value)) > 0;
}

function validateLength($value, $min, $max)
{
    $length = strlen(trim($value));

    return $length >= $min && $length <= $max;
}

function validateEmail($email)
{
    return filter_var(
        $email,
        FILTER_VALIDATE_EMAIL
    ) !== false;
}

function validatePhone($phone)
{
    return preg_match(
        '/^[0-9\-\(\) ]{7,20}$/',
        $phone
    );
}

function validateZip($zip)
{
    return preg_match(
        '/^\d{5}(-\d{4})?$/',
        $zip
    );
}

function validatePassword($password)
{
    return preg_match(
        '/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[^A-Za-z0-9]).{8,}$/',
        $password
    );
}