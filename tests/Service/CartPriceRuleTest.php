<?php
namespace inklabs\kommerce\Service;

use inklabs\kommerce\Entity;
use inklabs\kommerce\tests\Helper;
use inklabs\kommerce\tests\Helper\EntityRepository\FakeRepositoryCartPriceRule;

class CartPriceRuleTest extends Helper\DoctrineTestCase
{
    /** @var FakeRepositoryCartPriceRule */
    protected $cartPriceRuleRepository;

    /** @var CartPriceRule */
    protected $cartPriceRuleService;

    public function setUp()
    {
        $this->cartPriceRuleRepository = new FakeRepositoryCartPriceRule;
        $this->cartPriceRuleService = new CartPriceRule($this->cartPriceRuleRepository);
    }

    public function testCreate()
    {
        $cartPriceRule = $this->getDummyCartPriceRule();
        $this->cartPriceRuleService->create($cartPriceRule);
        $this->assertTrue($cartPriceRule instanceof Entity\CartPriceRule);
    }

    public function testEdit()
    {
        $newName = 'New Name';
        $cartPriceRule = $this->getDummyCartPriceRule();
        $this->assertNotSame($newName, $cartPriceRule->getName());

        $cartPriceRule->setName($newName);
        $this->cartPriceRuleService->edit($cartPriceRule);
        $this->assertSame($newName, $cartPriceRule->getName());
    }

    public function testFind()
    {
        $product = $this->cartPriceRuleService->find(1);
        $this->assertTrue($product instanceof Entity\CartPriceRule);
    }

    public function testFindMissing()
    {
        $this->cartPriceRuleRepository->setReturnValue(null);

        $product = $this->cartPriceRuleService->find(1);
        $this->assertSame(null, $product);
    }

    public function testFindAll()
    {
        $cartPriceRules = $this->cartPriceRuleService->findAll();

        $this->assertTrue($cartPriceRules[0] instanceof Entity\CartPriceRule);
    }
}
