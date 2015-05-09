<?php
namespace inklabs\kommerce\tests\Helper\EntityRepository;

use inklabs\kommerce\EntityRepository\CartInterface;
use inklabs\kommerce\Entity;

class FakeCart extends AbstractFake implements CartInterface
{
    public function __construct()
    {
        $this->setReturnValue(new Entity\Cart);
    }

    public function save(Entity\Cart & $cart)
    {
    }

    public function create(Entity\Cart & $cart)
    {
    }

    public function remove(Entity\Cart & $cart)
    {
    }

    public function find($id)
    {
        return $this->getReturnValue();
    }

    public function findByUser($userId)
    {
        return $this->getReturnValue();
    }

    public function findBySession($sessionId)
    {
        return $this->getReturnValue();
    }
}