<?php
namespace inklabs\kommerce\EntityDTO;

use inklabs\kommerce\Lib\UuidInterface;

final class OrderItemQtyDTO
{
    private $items;

    /**
     * @param UuidInterface $orderItemId
     * @param int $quantity
     */
    public function addOrderItemQty(UuidInterface $orderItemId, $quantity)
    {
        if ($quantity > 0) {
            $this->items[$orderItemId->getHex()] = (int) $quantity;
        }
    }

    public function getItems()
    {
        return $this->items;
    }

    /**
     * @param UuidInterface $orderItemId
     * @return null|int
     */
    public function getItemQuantity(UuidInterface $orderItemId)
    {
        if (isset($this->items[$orderItemId->getHex()])) {
            return $this->items[$orderItemId->getHex()];
        }

        return null;
    }
}
