<?php

namespace App\Services;

use App\Exceptions\EntityNotFoundException;
use App\Exceptions\InvalidEventException;
use App\Http\Requests\EventRequest;
use App\Jobs\AccountDeposit;
use App\Jobs\AccountWithDraw;
use App\Jobs\AccountWithTransfer;
use App\Repositories\AccountRepository;
use App\Utils\Enums\AccountEventType;
use Illuminate\Foundation\Bus\DispatchesJobs;

class AccountService
{
    use DispatchesJobs;

    private AccountRepository $accountRepository;

    /**
     * @param AccountRepository $accountRepository
     */
    public function __construct(AccountRepository $accountRepository)
    {
        $this->accountRepository = $accountRepository;
    }

    public function balance($accountId)
    {
        $account =  $this->accountRepository->getByAccountId($accountId);
        if(!$account){
            throw new EntityNotFoundException();
        }
        return $account->balance;
    }

    public function reset()
    {
        $this->accountRepository->reset();
    }

    public function event(EventRequest $eventRequest)
    {
        switch ($eventRequest->getEventType()){
            case AccountEventType::WITHDRAW:
                return $this->dispatch(new AccountWithDraw($eventRequest->getOrigin(), $eventRequest->getAmount()));
                break;
            case AccountEventType::TRANSFER:
                return $this->dispatch(new AccountWithTransfer($eventRequest->getOrigin(), $eventRequest->getDestination(), $eventRequest->getAmount()));
                break;
            case AccountEventType::DEPOSIT:
                return $this->dispatch(new AccountDeposit($eventRequest->getDestination(), $eventRequest->getAmount()));
                break;
            default:
                throw new InvalidEventException();
        }

    }

}
