<?php
namespace inklabs\kommerce\tests\Helper\EntityRepository;

use inklabs\kommerce\Entity\Cart;
use inklabs\kommerce\EntityRepository\CartRepositoryInterface;

class FakeCartRepository extends AbstractFakeRepository implements CartRepositoryInterface
{
    public function __construct()
    {
        $this->setReturnValue(new Cart);
    }

    public function find($id)
    {
        return $this->getReturnValue();
    }

    public function findOneByUser($userId)
    {
        return $this->getReturnValue();
    }

    public function findOneBySession($sessionId)
    {
        return $this->getReturnValue();
    }
}
