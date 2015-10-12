<?php
namespace inklabs\kommerce\EntityRepository;

use Exception;

class EntityNotModifiedException extends Exception
{
    public function __construct($message = '', $code = 400, Exception $previous = null, $exceptionData = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
