<?php

declare(strict_types=1);

namespace App\Constants;

final class UserRoleConstants
{
    public const USER = 'user';
    public const ADMIN = 'admin';

    public const ROLES = [
        self::USER,
        self::ADMIN
    ];

    public const ROLE_POWER = [
        self::USER => 1,
        self::ADMIN => 100,
    ];
}
