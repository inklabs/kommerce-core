<?php
namespace inklabs\kommerce\Entity\CartPriceRule;

use inklabs\kommerce\Entity as Entity;

class ItemTest extends \PHPUnit_Framework_TestCase
{
    public function testCreate()
    {
        $mock = $this->getMockForAbstractClass('inklabs\kommerce\Entity\CartPriceRule\Item');
        $mock->expects($this->any())
            ->method('matches')
            ->will($this->returnValue(true));

        $mock->setId(1);
        $mock->setQuantity(2);

        $this->assertTrue($mock->matches(new Entity\CartItem(new Entity\Product, 1)));
        $this->assertEquals(1, $mock->getId());
        $this->assertEquals(2, $mock->getQuantity());
    }
}
