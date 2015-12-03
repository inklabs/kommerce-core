<?php
namespace inklabs\kommerce\Action\Shipment;

final class OrderItemQtyDTO
{
    private $items;

    /**
     * @param int $orderItemId
     * @param int $quantity
     */
    public function addOrderItemQty($orderItemId, $quantity)
    {
        if ($quantity > 0) {
            $this->items[$orderItemId] = (int) $quantity;
        }
    }

    public function getItems()
    {
        return $this->items;
    }
}
