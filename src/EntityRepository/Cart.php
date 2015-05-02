<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity;

class Cart extends AbstractEntityRepository implements CartInterface
{
    public function save(Entity\Cart & $cart)
    {
        $this->saveEntity($cart);
    }

    public function create(Entity\Cart & $cart)
    {
        $this->persist($cart);
        $this->flush();
    }

    public function persist(Entity\Cart & $cart)
    {
        $this->persistEntity($cart);
    }

    public function findByUserOrSession($userId, $sessionId)
    {
        $userId = (int) $userId;
        $sessionId = (string) $sessionId;

        if (empty($userId) && empty($sessionId)) {
            return null;
        }

        $qb = $this->getQueryBuilder();

        $carts = $qb->select('cart')
            ->from('kommerce:Cart', 'cart')

            ->addSelect('user')
            ->leftJoin('kommerce:User', 'user')

            ->where('user.id = :userId')
            ->orWhere('cart.sessionId = :sessionId')
            ->setParameter('userId', $userId)
            ->setParameter('sessionId', $sessionId)
            ->setMaxResults(1)
            ->getQuery()
            ->getResult();

        return $carts[0];
    }
}
