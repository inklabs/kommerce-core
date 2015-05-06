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

    public function remove(Entity\Cart & $cart)
    {
        $this->removeEntity($cart);
        $this->flush();
    }

    public function persist(Entity\Cart & $cart)
    {
        $this->persistEntity($cart);
    }

    public function findByUser($userId)
    {
        return $this->findOneBy(['user' => $userId]);
    }

    public function findBySession($sessionId)
    {
        return $this->findOneBy(['sessionId' => $sessionId]);
    }
}
