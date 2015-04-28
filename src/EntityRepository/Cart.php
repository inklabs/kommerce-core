<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity;

class Cart extends AbstractEntityRepository implements CartInterface
{
    public function save(Entity\Cart & $order)
    {
        $this->saveEntity($order);
    }

    public function create(Entity\Cart & $order)
    {
        $this->createEntity($order);
    }
}
