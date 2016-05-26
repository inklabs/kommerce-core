<?php
namespace inklabs\kommerce\tests\Helper\EntityRepository;

use inklabs\kommerce\Entity\Cart;
use inklabs\kommerce\EntityRepository\CartRepositoryInterface;
use Ramsey\Uuid\UuidInterface;

class FakeCartRepository extends AbstractFakeRepository implements CartRepositoryInterface
{
    public function __construct()
    {
        $this->setReturnValue(new Cart);
    }

    public function findOneByUser($userId)
    {
        return $this->getReturnValue();
    }

    public function findOneBySession($sessionId)
    {
        return $this->getReturnValue();
    }

    /**
     * @param UuidInterface $uuid4
     * @return Cart
     */
    public function findOneByUuid(UuidInterface $uuid4)
    {
        // TODO: Implement findOneByUuid() method.
    }
}
