<?php
namespace inklabs\kommerce\Exception;

use Exception;

class KommerceException extends Exception
{
    public function __construct(string $message = '', int $code = 500, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
