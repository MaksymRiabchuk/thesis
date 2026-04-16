<?php

namespace App\Enum;

enum UserRole: string
{
    case ADMIN = 'admin';
    case USER = 'user';

    public static function getFrontendList(): array
    {
        $resultList = [];
        foreach (self::cases() as $case) {
            $resultList[$case->value] = $case->name;
        }
        return $resultList;
    }
}
