<?php
namespace inklabs\kommerce\Service;

use inklabs\kommerce\Entity;
use inklabs\kommerce\tests\Helper;
use inklabs\kommerce\tests\EntityRepository\FakeCartPriceRule;

class CartPriceRuleTest extends Helper\DoctrineTestCase
{
    /** @var FakeCartPriceRule */
    protected $repository;

    /** @var CartPriceRule */
    protected $service;

    public function setUp()
    {
        $this->repository = new FakeCartPriceRule;
        $this->service = new CartPriceRule($this->repository);
    }

    public function testFindAll()
    {
        $cartPriceRules = $this->service->findAll();

        $this->assertTrue($cartPriceRules[0] instanceof Entity\CartPriceRule);
    }
}
