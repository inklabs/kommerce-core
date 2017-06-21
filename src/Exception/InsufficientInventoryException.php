<?php
namespace inklabs\kommerce\Exception;

use Exception;

class InsufficientInventoryException extends KommerceException
{
    public function __construct(string $message = 'Insufficient Inventory', int $code = 400, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
