<?php
namespace inklabs\kommerce\Exception;

use Exception;

class UserLoginException extends KommerceException
{
    const USER_NOT_FOUND = 0;
    const USER_NOT_ACTIVE = 1;
    const INVALID_PASSWORD = 2;
    const TOKEN_NOT_FOUND = 3;
    const TOKEN_INVALID = 4;
    const TOKEN_EXPIRED = 5;

    public function __construct($message = '', $code = 401, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    public static function userNotFound()
    {
        return new self('User not found', self::USER_NOT_FOUND);
    }

    public static function userNotActive()
    {
        return new self('User not active', self::USER_NOT_ACTIVE);
    }

    public static function invalidPassword()
    {
        return new self('User password not valid', self::INVALID_PASSWORD);
    }

    public static function tokenNotFound()
    {
        return new self('Token not found', self::TOKEN_NOT_FOUND);
    }

    public static function tokenNotValid()
    {
        return new self('Token not valid', self::TOKEN_INVALID);
    }

    public static function tokenExpired()
    {
        return new self('Token expired', self::TOKEN_EXPIRED);
    }
}
