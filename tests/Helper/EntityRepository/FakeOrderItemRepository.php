<?php
namespace inklabs\kommerce\tests\Helper\EntityRepository;

use inklabs\kommerce\EntityRepository\OrderItemRepositoryInterface;
use inklabs\kommerce\Lib\ReferenceNumber;
use inklabs\kommerce\Entity;

class FakeOrderItemRepository extends AbstractFakeRepository implements OrderItemRepositoryInterface
{
    public function __construct()
    {
        $this->setReturnValue(new Entity\Order);
    }

    public function find($id)
    {
        return $this->getReturnValue();
    }

    public function create(Entity\OrderItem & $orderItem)
    {
        $this->throwCrudExceptionIfSet();
    }

    public function save(Entity\OrderItem & $orderItem)
    {
        $this->throwCrudExceptionIfSet();
    }

    public function remove(Entity\OrderItem & $orderItem)
    {
        $this->throwCrudExceptionIfSet();
    }

    public function persist(Entity\OrderItem & $orderItem)
    {
        $this->throwCrudExceptionIfSet();
    }

    public function flush()
    {
    }
}
