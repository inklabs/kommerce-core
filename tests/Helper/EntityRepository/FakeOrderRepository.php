<?php
namespace inklabs\kommerce\tests\Helper\EntityRepository;

use inklabs\kommerce\Entity\Order;
use inklabs\kommerce\Entity\OrderItem;
use inklabs\kommerce\Entity\Pagination;
use inklabs\kommerce\Entity\Price;
use inklabs\kommerce\Entity\Product;
use inklabs\kommerce\EntityRepository\OrderRepositoryInterface;
use inklabs\kommerce\Lib\ReferenceNumber;

/**
 * @method Order findOneById($id)
 */
class FakeOrderRepository extends AbstractFakeRepository implements OrderRepositoryInterface
{
    public function __construct()
    {
        $orderItem = new OrderItem;
        $orderItem->setProduct(new Product);
        $orderItem->setPrice(new Price);

        $order = new Order;
        $order->addOrderItem($orderItem);

        $this->setReturnValue($order);
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

    public function setReferenceNumberGenerator(ReferenceNumber\GeneratorInterface $referenceNumberGenerator)
    {
    }

    public function referenceNumberExists($referenceNumber)
    {
    }
}
