<?php
namespace inklabs\kommerce\Service;

use inklabs\kommerce\Entity\Order;
use inklabs\kommerce\Entity\Pagination;
use inklabs\kommerce\Entity\Shipment;
use inklabs\kommerce\EntityRepository\EntityNotFoundException;

interface OrderServiceInterface
{
    public function update(Order & $order);

    /**
     * @param int $id
     * @return Order
     * @throws EntityNotFoundException
     */
    public function findOneById($id);

    public function getLatestOrders(Pagination & $pagination = null);

    /**
     * @param int $userId
     * @return Order[]
     */
    public function getOrdersByUserId($userId);

    /**
     * @param int $orderId
     * @param Shipment $shipment
     */
    public function addShipment($orderId, $shipment);
}
