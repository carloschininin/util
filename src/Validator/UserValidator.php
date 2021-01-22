<?php

declare(strict_types=1);

/*
 * This file is part of the PIDIA
 * (c) Carlos Chininin <cio@pidia.pe>
 */

namespace CarlosChininin\Util\Validator\User;

use InvalidArgumentException;

function validateUsername(?string $username): string
{
    if (empty($username)) {
        throw new InvalidArgumentException('The username can not be empty.');
    }

    if (1 !== preg_match('/^[a-z_]+$/', $username)) {
        throw new InvalidArgumentException('The username must contain only lowercase latin characters and underscores.');
    }

    return $username;
}

function validatePassword(?string $plainPassword): string
{
    if (empty($plainPassword)) {
        throw new InvalidArgumentException('The password can not be empty.');
    }

    if (mb_strlen(trim($plainPassword)) < 6) {
        throw new InvalidArgumentException('The password must be at least 6 characters long.');
    }

    return $plainPassword;
}

function validateEmail(?string $email): string
{
    if (empty($email)) {
        throw new InvalidArgumentException('The email can not be empty.');
    }

    if (false === mb_strpos($email, '@')) {
        throw new InvalidArgumentException('The email should look like a real email.');
    }

    return $email;
}

function validateFullName(?string $fullName): string
{
    if (empty($fullName)) {
        throw new InvalidArgumentException('The full name can not be empty.');
    }

    return $fullName;
}
