<?php
namespace inklabs\kommerce\tests\Helper\EntityRepository;

use inklabs\kommerce\Entity\EntityInterface;
use inklabs\kommerce\Entity\Order;
use inklabs\kommerce\Entity\OrderItem;
use inklabs\kommerce\Entity\Pagination;
use inklabs\kommerce\Entity\Price;
use inklabs\kommerce\Entity\Product;
use inklabs\kommerce\EntityRepository\OrderRepositoryInterface;
use inklabs\kommerce\Lib\ReferenceNumber\ReferenceNumberGeneratorInterface;

/**
 * @method Order findOneById($id)
 */
class FakeOrderRepository extends AbstractFakeRepository implements OrderRepositoryInterface
{
    /** @var int */
    protected $shipmentAutoincrementId = 1;

    public function __construct()
    {
        $orderItem = new OrderItem;
        $orderItem->setProduct(new Product);
        $orderItem->setPrice(new Price);

        $order = new Order;
        $order->addOrderItem($orderItem);

        $this->setReturnValue($order);
    }

    public function update(EntityInterface & $entity)
    {
        parent::update($entity);

        /** @var Order $entity */
        $this->setShipmentIds($entity);
    }

    public function findOneByExternalId($orderExternalId)
    {
        return $this->getReturnValue();
    }

    public function getLatestOrders(Pagination & $pagination = null)
    {
        return $this->getReturnValueAsArray();
    }

    public function getOrdersByUserId($userId)
    {
        return $this->getReturnValueAsArray();
    }

    public function setReferenceNumberGenerator(ReferenceNumberGeneratorInterface $referenceNumberGenerator)
    {
    }

    public function referenceNumberExists($referenceNumber)
    {
    }

    private function getShipmentAutoincrementId()
    {
        return $this->shipmentAutoincrementId++;
    }

    private function setShipmentIds(Order & $entity)
    {
        foreach ($entity->getShipments() as $shipment) {
            if ($shipment->getId() === null) {
                $shipment->setId($this->getShipmentAutoincrementId());
            }
        }
    }
}
