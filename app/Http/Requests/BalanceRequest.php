<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BalanceRequest extends FormRequest
{
    /**
     * Método retorna os parametros
     *
     * @return int
     */
    public function getAccountId()
    {
        return (int)$this->query('account_id');
    }

    public function rules(){
        return [];
    }
}
