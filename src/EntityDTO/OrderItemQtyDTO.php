<?php
namespace inklabs\kommerce\EntityDTO;

use Ramsey\Uuid\UuidInterface;

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
}
