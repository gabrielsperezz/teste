<?php

namespace App\Http\Controllers;

use App\Http\Requests\BalanceRequest;
use App\Http\Requests\EventRequest;
use App\Services\AccountService;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    private AccountService $accountService;

    /**
     * @param AccountService $accountService
     */
    public function __construct(AccountService $accountService)
    {
        $this->accountService = $accountService;
    }

    public function reset()
    {
        $this->accountService->reset();
        return response('OK', Response::HTTP_OK);
    }

    public function balance(BalanceRequest $balanceRequest)
    {
        return new JsonResponse($this->accountService->balance($balanceRequest->getAccountId()), Response::HTTP_OK);
    }

    public function event(EventRequest $eventRequest)
    {
        $eventData = $this->accountService->event($eventRequest);
        return new JsonResponse($eventData, Response::HTTP_CREATED);
    }
}
