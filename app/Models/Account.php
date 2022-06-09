<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int|mixed $balance
 * @property mixed $account_id
 */
class Account extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'balance',
        'account_id'
    ];

    public function map()
    {
        return [
            'id' => $this->account_id,
            'balance' => $this->balance,
        ];
    }
}
