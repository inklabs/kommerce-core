<?php
namespace inklabs\kommerce\Exception;

use Exception;

class Kommerce400Exception extends KommerceException
{
    public function __construct($message = '', $code = 400, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
