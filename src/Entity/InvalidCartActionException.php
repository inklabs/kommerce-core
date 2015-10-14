<?php
namespace inklabs\kommerce\Entity;

use Exception;

class InvalidCartActionException extends Exception
{
    public function __construct($message = '', $code = 400, Exception $previous = null, $exceptionData = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
