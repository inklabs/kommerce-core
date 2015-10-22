<?php
namespace inklabs\kommerce\Service;

use Exception;

class UserLoginException extends Exception
{
    const USER_NOT_FOUND = 0;
    const USER_NOT_ACTIVE = 1;
    const INVALID_PASSWORD = 2;
    const TOKEN_NOT_FOUND = 3;
    const TOKEN_INVALID = 4;
    const TOKEN_EXPIRED = 5;

    public function __construct($message = '', $code = 401, Exception $previous = null, $exceptionData = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
