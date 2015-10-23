<?php
namespace inklabs\kommerce\Entity;

use Exception;

class UserPasswordException extends Exception
{
    public function __construct($message = '', $code = 0, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
