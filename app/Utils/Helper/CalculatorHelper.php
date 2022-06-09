<?php

namespace App\Utils\Helper;

use App\Models\Account;

class CalculatorHelper
{
    public static function accountHasValue(Account $account, $amount)
    {
        return $account->balance >= $amount;
    }
}
