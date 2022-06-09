<?php

namespace App\Jobs;

use App\Models\Account;
use App\Repositories\AccountRepository;
use Illuminate\Foundation\Bus\Dispatchable;

class AccountDeposit
{
    use Dispatchable;

    private mixed $accountDestination;
    private int $amount;
    private AccountRepository $accountRepository;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($accountDestination, $amount)
    {
        $this->accountDestination = $accountDestination;
        $this->amount = $amount;
    }

    /**
     * Execute the job.
     *
     * @return array
     */
    public function handle(AccountRepository $accountRepository)
    {
        $this->accountRepository = $accountRepository;
        $account = $this->accountRepository->getByAccountId($this->accountDestination);
        return $this->start($account);
    }

    /**
     * @param Account|null $account
     * @return array
     */
    private function start(Account $account = null)
    {
        if(!$account){
            $account = new Account();
            $account->account_id = $this->accountDestination;
        }
        $account->balance += $this->amount;
        $this->accountRepository->save($account);
        return ['destination' => $account->map()];
    }
}
