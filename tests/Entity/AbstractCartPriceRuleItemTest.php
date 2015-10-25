<?php
namespace inklabs\kommerce\Entity;

use inklabs\kommerce\tests\Helper\DoctrineTestCase;

class AbstractCartPriceRuleItemTest extends DoctrineTestCase
{
    public function testCreate()
    {
        /** @var AbstractCartPriceRuleItem|\PHPUnit_Framework_MockObject_MockObject $mock */
        $mock = $this->getMockForAbstractClass(AbstractCartPriceRuleItem::class);
        $mock->expects($this->any())
            ->method('matches')
            ->will($this->returnValue(true));

        $mock->setQuantity(2);
        $mock->setCartPriceRule(new CartPriceRule);

        $this->assertEntityValid($mock);
        $this->assertTrue($mock->matches(new CartItem(new Product, 1)));
        $this->assertSame(2, $mock->getQuantity());
        $this->assertTrue($mock->getCartPriceRule() instanceof CartPriceRule);
    }
}
