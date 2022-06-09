<?php

namespace App\Jobs;

use App\Exceptions\AccountHasNotValueException;
use App\Exceptions\EntityNotFoundException;
use App\Models\Account;
use App\Repositories\AccountRepository;
use App\Utils\Helper\CalculatorHelper;
use Illuminate\Foundation\Bus\Dispatchable;

class AccountWithTransfer
{
    use Dispatchable;

    private int $amount;
    private mixed$accountOrigin;
    private mixed $accountDestination;
    private AccountRepository $accountRepository;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($accountOrigin, $accountDestination ,$amount)
    {
        $this->accountDestination = $accountDestination;
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
        $originAccount = $this->accountRepository->getByAccountId($this->accountOrigin);
        $destinationAccount = $this->accountRepository->getByAccountId($this->accountDestination);
        return $this->start($originAccount, $destinationAccount);
    }

    private function start(Account $originAccount = null, Account $destinationAccount = null)
    {
        $this->validateAccount($originAccount, $destinationAccount);
        $originAccount->balance -= $this->amount;
        $destinationAccount->balance += $this->amount;
        $this->accountRepository->save($originAccount);
        $this->accountRepository->save($destinationAccount);
        return ['origin' => $originAccount->map(), 'destination' => $destinationAccount->map()];
    }

    private function validateAccount(Account $originAccount = null, Account $destinationAccount = null)
    {
        if(!$originAccount || !$destinationAccount){
            throw new EntityNotFoundException();
        }
        if(!CalculatorHelper::accountHasValue($originAccount, $this->amount)){
            throw new AccountHasNotValueException();
        }
        return true;
    }
}
