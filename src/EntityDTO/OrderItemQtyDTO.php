<?php
namespace inklabs\kommerce\EntityDTO;

use inklabs\kommerce\Lib\UuidInterface;

final class OrderItemQtyDTO
{
    private $items;

    public function addOrderItemQty(UuidInterface $orderItemId, int $quantity): void
    {
        if ($quantity > 0) {
            $this->items[$orderItemId->getHex()] = $quantity;
        }
    }

    public function getItems()
    {
        return $this->items;
    }

    public function getItemQuantity(UuidInterface $orderItemId): ?int
    {
        if (isset($this->items[$orderItemId->getHex()])) {
            return $this->items[$orderItemId->getHex()];
        }

        return null;
    }
}
