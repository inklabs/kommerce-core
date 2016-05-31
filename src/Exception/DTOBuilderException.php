<?php
namespace inklabs\kommerce\Exception;

class DTOBuilderException extends Kommerce400Exception
{
    const INVALID_PAYMENT = 1;

    public static function invalidPayment()
    {
        return new self('Invalid payment', self::INVALID_PAYMENT);
    }
}
