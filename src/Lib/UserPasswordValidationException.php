<?php
namespace inklabs\kommerce\Lib;

use Exception;

class UserPasswordValidationException extends Exception
{
    public function __construct($message = '', $code = 0, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
