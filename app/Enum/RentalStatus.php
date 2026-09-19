<?php

namespace App\Enum;

enum RentalStatus: string
{
    case PENDING = 'pending';
    case CONFIRMED = 'confirmed';
    case ACTIVE = 'active';
    case COMPLETED = 'completed';
    case CANCELLED = 'cancelled';

    /**
     * @return array<int, string>
     */
    public static function blocking(): array
    {
        return [self::PENDING->value, self::CONFIRMED->value, self::ACTIVE->value];
    }
}
