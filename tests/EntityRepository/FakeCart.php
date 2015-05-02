<?php
namespace inklabs\kommerce\tests\EntityRepository;

use inklabs\kommerce\EntityRepository\CartInterface;
use inklabs\kommerce\Entity;
use inklabs\kommerce\View;
use inklabs\kommerce\tests\Helper;

class FakeCart extends Helper\AbstractFake implements CartInterface
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

    public function find($id)
    {
        return $this->getReturnValue();
    }

    public function findByUserOrSession($userId, $sessionId)
    {
        return $this->getReturnValue();
    }
}
