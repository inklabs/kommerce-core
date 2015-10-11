<?php
namespace inklabs\kommerce\EntityRepository;

use Exception;

class EntityNotFoundException extends Exception
{
    public function __construct($message = '', $code = 404, Exception $previous = null, $exceptionData = null)
    {
        $this->exceptionData = $exceptionData;
        if (! is_string($message)) {
            $this->exceptionData = $message;
            $message = '';
        }
        parent::__construct($message, $code, $previous);
    }
}
