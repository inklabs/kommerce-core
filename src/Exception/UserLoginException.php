<?php
namespace inklabs\kommerce\Exception;

use Exception;

class UserLoginException extends KommerceException
{
    const USER_NOT_FOUND = 0;
    const USER_NOT_ACTIVE = 1;
    const INVALID_PASSWORD = 2;
    const TOKEN_NOT_FOUND = 3;
    const TOKEN_INVALID = 4;
    const TOKEN_EXPIRED = 5;

    public function __construct($message = '', $code = 401, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
