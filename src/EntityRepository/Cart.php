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
        $this->createEntity($cart);
    }
}
