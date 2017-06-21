<?php
namespace inklabs\kommerce\Exception;

use Exception;

class EntityNotFoundException extends KommerceException
{
    public function __construct(string $message = '', int $code = 404, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
