<?php
namespace inklabs\kommerce\Exception;

class InvalidCartActionException extends Kommerce400Exception
{
    public static function invalidQuantity(int $quantity)
    {
        return new self('Invalid quantity: ' . $quantity);
    }
}
