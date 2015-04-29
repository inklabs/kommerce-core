<?php
namespace inklabs\kommerce\tests\EntityRepository;

use inklabs\kommerce\EntityRepository\CartPriceRuleInterface;
use inklabs\kommerce\Entity;
use inklabs\kommerce\View;
use inklabs\kommerce\tests\Helper;

class FakeCartPriceRule extends Helper\AbstractFake implements CartPriceRuleInterface
{
    public function __construct()
    {
        $this->setReturnValue(new Entity\CartPriceRule);
    }

    public function find($id)
    {
        return $this->getReturnValue();
    }

    public function findAll()
    {
        return $this->getReturnValueAsArray();
    }
}
