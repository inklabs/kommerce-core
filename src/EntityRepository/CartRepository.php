<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity\Cart;
use Ramsey\Uuid\UuidInterface;

class CartRepository extends AbstractRepository implements CartRepositoryInterface
{
    public function findOneByUserId(UuidInterface $userId)
    {
        return $this->returnOrThrowNotFoundException(
            $this->findOneBy(['user' => $userId])
        );
    }

    public function findOneBySession($sessionId)
    {
        return $this->returnOrThrowNotFoundException(
            $this->findOneBy(['sessionId' => $sessionId])
        );
    }

    /**
     * @param UuidInterface $uuid4
     * @return Cart
     */
    public function findOneByUuid(UuidInterface $uuid4)
    {
        return $this->returnOrThrowNotFoundException(
            parent::findOneBy(['id' => $uuid4])
        );
    }
}
