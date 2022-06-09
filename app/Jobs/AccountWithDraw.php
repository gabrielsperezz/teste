<?php

namespace App\Jobs;

use App\Exceptions\AccountHasNotValueException;
use App\Exceptions\EntityNotFoundException;
use App\Models\Account;
use App\Repositories\AccountRepository;
use App\Utils\Helper\CalculatorHelper;
use Illuminate\Foundation\Bus\Dispatchable;

class AccountWithDraw
{
    use Dispatchable;

    private $accountOrigin;
    private int $amount;
    private AccountRepository $accountRepository;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($accountOrigin, $amount)
    {
        $this->accountOrigin = $accountOrigin;
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
        $account = $this->accountRepository->getByAccountId($this->accountOrigin);
        return $this->start($account);
    }

    private function start(Account $account = null)
    {
        $this->validateAccount($account);

        $account->balance -= $this->amount;
        $this->accountRepository->save($account);
        return ['origin' => $account->map()];
    }

    /**
     * @param Account|null $account
     * @return bool
     */
    private function validateAccount(Account $account = null)
    {
        if(!$account){
            throw new EntityNotFoundException();
        }
        if(!CalculatorHelper::accountHasValue($account, $this->amount)){
            throw new AccountHasNotValueException();
        }
        return true;
    }
}
