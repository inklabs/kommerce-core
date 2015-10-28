<?php
namespace inklabs\kommerce\Action\Shipment;

final class OrderItemQtyDTO
{
    private $items;

    /**
     * @param int $orderItemId
     * @param int $qty
     */
    public function addOrderItemQty($orderItemId, $qty)
    {
        $this->items[$orderItemId] = $qty;
    }

    public function getItems()
    {
        return $this->items;
    }
}
