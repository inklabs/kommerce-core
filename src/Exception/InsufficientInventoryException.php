<?php
namespace inklabs\kommerce\Exception;

use Exception;

class InsufficientInventoryException extends KommerceException
{
    public function __construct($message = 'Insufficient Inventory', $code = 400, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
