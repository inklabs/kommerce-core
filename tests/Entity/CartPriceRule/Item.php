<?php
namespace inklabs\kommerce\Entity\CartPriceRule;

use inklabs\kommerce\Entity as Entity;

class ItemTest extends \PHPUnit_Framework_TestCase
{
    public function testCreate()
    {
        $stub = $this->getMockForAbstractClass('inklabs\kommerce\Entity\CartPriceRule\Item');
        $stub->expects($this->any())
            ->method('matches')
            ->will($this->returnValue(true));

        $this->assertTrue($stub->matches(new Entity\CartItem(new Entity\Product, 1)));
    }
}
