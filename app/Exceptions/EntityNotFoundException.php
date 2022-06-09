<?php

namespace App\Exceptions;

use Symfony\Component\HttpKernel\Exception\HttpException;
use Exception;

/**
 * Class EntityNotFoundException
 *
 * Classe de excessão quando alguma entidade não é encotrada
 *
 * @package App\Exceptions
 */
class EntityNotFoundException extends HttpException
{
    public function __construct($message = "", $code = 404, Exception $previous = null)
    {
        parent::__construct($code, $message, $previous, [], $code);
    }
}
