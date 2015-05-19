<?php
namespace inklabs\kommerce\tests\Helper\EntityRepository;

use inklabs\kommerce\EntityRepository\OrderInterface;
use inklabs\kommerce\Lib\ReferenceNumber;
use inklabs\kommerce\Entity;

class FakeOrder extends AbstractFake implements OrderInterface
{
    public function __construct()
    {
        $orderItem = new Entity\OrderItem;
        $orderItem->setProduct(new Entity\Product);
        $orderItem->setPrice(new Entity\Price);

        $order = new Entity\Order;
        $order->addOrderItem($orderItem);

        $this->setReturnValue($order);
    }

    public function find($id)
    {
        return $this->getReturnValue();
    }

    public function findOneBy(array $criteria, array $orderBy = null)
    {
        return $this->getReturnValue();
    }

    public function getLatestOrders(Entity\Pagination & $pagination = null)
    {
        return $this->getReturnValueAsArray();
    }

    public function getOrdersByUserId($userId)
    {
        return $this->getReturnValueAsArray();
    }

    public function create(Entity\Order & $order)
    {
    }

    public function save(Entity\Order & $order)
    {
    }

    public function persist(Entity\Order & $order)
    {
    }

    public function setReferenceNumberGenerator(ReferenceNumber\GeneratorInterface $referenceNumberGenerator)
    {
    }

    public function referenceNumberExists($referenceNumber)
    {
    }
}
