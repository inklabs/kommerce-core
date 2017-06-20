<?php
namespace inklabs\kommerce\Lib\Authorization;

use Exception;
use inklabs\kommerce\Exception\KommerceException;

class AuthorizationContextException extends KommerceException
{
    public function __construct(string $message = '', int $code = 403, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    public static function cartAccessDenied()
    {
        return new self('Access denied to cart');
    }

    public static function userAccessDenied()
    {
        return new self('Access denied to user');
    }

    public static function accessDenied()
    {
        return new self('Access denied');
    }
}
