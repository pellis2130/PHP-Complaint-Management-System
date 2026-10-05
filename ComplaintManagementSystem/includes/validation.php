<?php

function validateRequired($value)
{
    return strlen(trim($value)) > 0;
}

function validateLength($value, $min, $max)
{
    $length = strlen(trim($value));

    return $length >= $min &&
           $length <= $max;
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
    $phone = trim($phone);

    if (
        strlen($phone) < 7 ||
        strlen($phone) > 20
    ) {
        return false;
    }

    if (!preg_match('/^[0-9\-\(\)\+\s]+$/', $phone)) {
        return false;
    }

    $digits = preg_replace('/\D/', '', $phone);

    return strlen($digits) >= 7;
}

function validateZip($zip)
{
    return preg_match(
        '/^\d{5}(-\d{4})?$/',
        trim($zip)
    );
}

function validatePassword($password)
{
    return preg_match(
        '/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[^A-Za-z0-9]).{8,}$/',
        $password
    );
}