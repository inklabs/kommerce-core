<?php
namespace inklabs\kommerce\tests\Helper\EntityRepository;

use inklabs\kommerce\Entity\Order;
use inklabs\kommerce\EntityRepository\OrderItemRepositoryInterface;
use inklabs\kommerce\Lib\ReferenceNumber;

class FakeOrderItemRepository extends AbstractFakeRepository implements OrderItemRepositoryInterface
{
    public function __construct()
    {
        $this->setReturnValue(new Order);
    }

    public function find($id)
    {
        return $this->getReturnValue();
    }
}
