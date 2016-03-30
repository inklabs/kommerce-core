<?php
namespace inklabs\kommerce\Exception;

use Exception;

class EntityNotFoundException extends KommerceException
{
    public function __construct($message = '', $code = 404, Exception $previous = null, $exceptionData = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
