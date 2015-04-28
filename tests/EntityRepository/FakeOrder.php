<?php
namespace inklabs\kommerce\tests\EntityRepository;

use inklabs\kommerce\EntityRepository\OrderInterface;
use inklabs\kommerce\Entity;
use inklabs\kommerce\tests\Helper;

class FakeOrder extends Helper\AbstractFake implements OrderInterface
{
    public function __construct()
    {
        $this->setReturnValue(new Entity\Order);
    }

    public function find($id)
    {
        return $this->getReturnValue();
    }

    public function getLatestOrders(Entity\Pagination & $pagination = null)
    {
        return $this->getReturnValueAsArray();
    }

    public function persist(Entity\Order & $order)
    {
    }

    public function flush()
    {
    }
}
