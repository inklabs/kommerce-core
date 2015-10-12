<?php
namespace inklabs\kommerce\EntityRepository;

use Exception;

class EntityNotFoundException extends Exception
{
    public function __construct($message = '', $code = 404, Exception $previous = null, $exceptionData = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
