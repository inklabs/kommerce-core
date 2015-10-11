<?php
namespace inklabs\kommerce\Service;

use inklabs\kommerce\Entity\CartPriceRule;
use inklabs\kommerce\tests\Helper;
use inklabs\kommerce\tests\Helper\EntityRepository\FakeCartPriceRuleRepository;

class CartPriceRuleServiceTest extends Helper\DoctrineTestCase
{
    /** @var FakeCartPriceRuleRepository */
    protected $cartPriceRuleRepository;

    /** @var CartPriceRuleService */
    protected $cartPriceRuleService;

    public function setUp()
    {
        $this->cartPriceRuleRepository = new FakeCartPriceRuleRepository;
        $this->cartPriceRuleService = new CartPriceRuleService($this->cartPriceRuleRepository);
    }

    public function testCreate()
    {
        $cartPriceRule = $this->getDummyCartPriceRule();
        $this->cartPriceRuleService->create($cartPriceRule);
        $this->assertTrue($cartPriceRule instanceof CartPriceRule);
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
        $this->cartPriceRuleRepository->create(new CartPriceRule);
        $product = $this->cartPriceRuleService->findOneById(1);
        $this->assertTrue($product instanceof CartPriceRule);
    }

    /**
     * @expectedException \inklabs\kommerce\EntityRepository\EntityNotFoundException
     */
    public function testFindMissing()
    {
        $this->cartPriceRuleService->findOneById(1);
    }

    public function testFindAll()
    {
        $cartPriceRules = $this->cartPriceRuleService->findAll();

        $this->assertTrue($cartPriceRules[0] instanceof CartPriceRule);
    }
}
