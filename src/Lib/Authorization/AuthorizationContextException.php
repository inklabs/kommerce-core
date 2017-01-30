<?php
namespace inklabs\kommerce\Lib\Authorization;

use Exception;
use inklabs\kommerce\Exception\KommerceException;
use inklabs\kommerce\Lib\UuidInterface;

class AuthorizationContextException extends KommerceException
{
    public function __construct($message = '', $code = 403, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    public static function userAccessDenied()
    {
        return new self('Access denied to user');
    }
}
