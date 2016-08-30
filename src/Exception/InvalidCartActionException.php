<?php
namespace inklabs\kommerce\Exception;

class InvalidCartActionException extends Kommerce400Exception
{
    /**
     * @param int $quantity
     * @return InvalidCartActionException
     */
    public static function invalidQuantity($quantity)
    {
        return new self('Invalid quantity: ' . (int) $quantity);
    }
}
