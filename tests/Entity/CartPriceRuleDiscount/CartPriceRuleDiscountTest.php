<?php
namespace inklabs\kommerce\Entity\CartPriceRuleDiscount;

use inklabs\kommerce\Entity as Entity;

class CartPriceRuleDiscountTest extends \PHPUnit_Framework_TestCase
{
    public function testCreate()
    {
        /* @var Discount $mock */
        $mock = $this->getMockForAbstractClass('inklabs\kommerce\Entity\CartPriceRuleDiscount\Discount');

        $mock->setId(1);
        $mock->setQuantity(2);
        $mock->setCartPriceRule(new Entity\CartPriceRule);

        $this->assertEquals(1, $mock->getId());
        $this->assertEquals(2, $mock->getQuantity());
        $this->assertInstanceOf('inklabs\kommerce\Entity\CartPriceRule', $mock->getCartPriceRule());
    }
}
