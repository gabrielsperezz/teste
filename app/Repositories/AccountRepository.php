<?php

namespace App\Repositories;

use App\Models\Account;
use Illuminate\Database\Eloquent\Model;

class AccountRepository extends AbstractRepository
{

    /**
     * AbstractRepository constructor.
     *
     * @param Account $model
     */
    public function __construct(Account $model)
    {
        parent::__construct($model);
    }

    /**
     * @param $accountId
     * @return \Illuminate\Database\Eloquent\Builder|Model|object
     */
    public function getByAccountId($accountId)
    {
        return $this->model::query()->where('account_id', '=', $accountId)->first();
    }

    /**
     * @param Account $account
     * @return Account
     */
    public function save(Account $account): Account
    {
        $account->save();
        return $account;
    }


    /**
     * @return void
     */
    public function reset(): void
    {
        $this->model::query()->delete();

        $account = new Account();
        $account->fill(['account_id' => 300, 'balance' => 0]);
        $account->save();
    }

}
