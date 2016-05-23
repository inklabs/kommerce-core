<?php
namespace inklabs\kommerce\Exception;

class ManagedFileException extends Kommerce400Exception
{
    const INVALID_METHOD_CALL = 1;

    public static function invalidMethodCall()
    {
        return new self('Invalid method call', self::INVALID_METHOD_CALL);
    }
}
