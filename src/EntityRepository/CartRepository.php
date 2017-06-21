<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity\Cart;
use inklabs\kommerce\Entity\CartItem;
use inklabs\kommerce\Exception\EntityNotFoundException;
use inklabs\kommerce\Lib\UuidInterface;

class CartRepository extends AbstractRepository implements CartRepositoryInterface
{
    public function findOneByUserId(UuidInterface $userId): Cart
    {
        return $this->returnOrThrowNotFoundException(
            $this->findOneBy(['user' => $userId])
        );
    }

    public function findOneBySession(string $sessionId): Cart
    {
        return $this->returnOrThrowNotFoundException(
            $this->findOneBy(['sessionId' => $sessionId])
        );
    }

    public function findOneById(UuidInterface $uuid4): Cart
    {
        return $this->returnOrThrowNotFoundException(
            parent::findOneBy(['id' => $uuid4])
        );
    }

    public function getItemById(UuidInterface $cartItemId): CartItem
    {
        return $this->returnOrThrowNotFoundException(
            $this->getQueryBuilder()
                ->select('CartItem')
                ->from(CartItem::class, 'CartItem')
                ->where('CartItem.id = :id')
                ->setIdParameter('id', $cartItemId)
                ->getQuery()
                ->getOneOrNullResult(),
            CartItem::class
        );
    }
}
