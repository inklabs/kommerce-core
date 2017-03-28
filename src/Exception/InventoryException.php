<?php
namespace inklabs\kommerce\Exception;

class InventoryException extends Kommerce400Exception
{
    const MISSING_INVENTORY_HOLD = 1;

    public static function missingInventoryHoldLocation()
    {
        return new self('Inventory Hold location is missing', self::MISSING_INVENTORY_HOLD);
    }
}
