<?php
namespace inklabs\kommerce\Service;

use inklabs\kommerce\Entity;
use inklabs\kommerce\tests\Helper;
use inklabs\kommerce\tests\EntityRepository\FakeCartPriceRule;

class CartPriceRuleTest extends Helper\DoctrineTestCase
{
    /** @var FakeCartPriceRule */
    protected $cartPriceRuleRepository;

    /** @var CartPriceRule */
    protected $cartPriceRuleService;

    public function setUp()
    {
        $this->cartPriceRuleRepository = new FakeCartPriceRule;
        $this->cartPriceRuleService = new CartPriceRule($this->cartPriceRuleRepository);
    }

    public function testFindAll()
    {
        $cartPriceRules = $this->cartPriceRuleService->findAll();

        $this->assertTrue($cartPriceRules[0] instanceof Entity\CartPriceRule);
    }
}
