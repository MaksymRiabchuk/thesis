<?php

namespace App\Enum;

enum TransactionType: string
{
    case CHARGE = 'charge';
    case REFUND = 'refund';
    case PAYOUT = 'payout';
}
