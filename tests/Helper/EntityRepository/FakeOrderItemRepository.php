<?php
namespace inklabs\kommerce\tests\Helper\EntityRepository;

use inklabs\kommerce\Entity\OrderItem;
use inklabs\kommerce\EntityRepository\OrderItemRepositoryInterface;
use inklabs\kommerce\Lib\ReferenceNumber;

/**
 * @method OrderItem findOneById($id)
 */
class FakeOrderItemRepository extends FakeRepository implements OrderItemRepositoryInterface
{
    public function __construct()
    {
        $this->setReturnValue(new OrderItem);
    }
}
