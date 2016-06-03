<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity\Cart;
use inklabs\kommerce\Entity\CartItem;
use inklabs\kommerce\Exception\EntityNotFoundException;
use inklabs\kommerce\Lib\UuidInterface;

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
    public function findOneById(UuidInterface $uuid4)
    {
        return $this->returnOrThrowNotFoundException(
            parent::findOneBy(['id' => $uuid4])
        );
    }

    /**
     * @param UuidInterface $cartItemId
     * @return CartItem
     * @throws EntityNotFoundException
     */
    public function getItemById(UuidInterface $cartItemId)
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
