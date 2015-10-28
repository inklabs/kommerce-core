<?php
namespace inklabs\kommerce\Service;

use inklabs\kommerce\Action\Shipment\OrderItemQtyDTO;
use inklabs\kommerce\Entity\Order;
use inklabs\kommerce\Entity\Pagination;
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
     * @param OrderItemQtyDTO $orderItemQtyDTO
     * @param string $comment
     * @param string $rateExternalId
     * @param string $shipmentExternalId
     */
    public function addShipment(
        $orderId,
        OrderItemQtyDTO $orderItemQtyDTO,
        $comment,
        $rateExternalId,
        $shipmentExternalId
    );
}
