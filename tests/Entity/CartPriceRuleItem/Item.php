<?php
namespace inklabs\kommerce\Entity\CartPriceRuleItem;

use inklabs\kommerce\Entity as Entity;

class ItemTest extends \PHPUnit_Framework_TestCase
{
    public function testCreate()
    {
        /* @var Item $mock */
        $mock = $this->getMockForAbstractClass('inklabs\kommerce\Entity\CartPriceRuleItem\Item');
        $mock->expects($this->any())
            ->method('matches')
            ->will($this->returnValue(true));

        $mock->setId(1);
        $mock->setQuantity(2);
        $mock->setCartPriceRule(new Entity\CartPriceRule);

        $this->assertTrue($mock->matches(new Entity\CartItem(new Entity\Product, 1)));
        $this->assertEquals(1, $mock->getId());
        $this->assertEquals(2, $mock->getQuantity());
        $this->assertTrue($mock->getCartPriceRule() instanceof Entity\CartPriceRule);
    }
}
