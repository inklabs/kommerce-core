<?php
namespace inklabs\kommerce\Service;

use Exception;

class InsufficientInventoryException extends Exception
{
    public function __construct(
        $message = 'Insufficient Inventory',
        $code = 400,
        Exception $previous = null,
        $exceptionData = null
    ) {
        parent::__construct($message, $code, $previous);
    }
}
