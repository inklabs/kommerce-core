<?php
namespace inklabs\kommerce\Entity\CartPriceRuleDiscount;

use inklabs\kommerce\Entity as Entity;

class TagTest extends \PHPUnit_Framework_TestCase
{
    public function testCreate()
    {
        $priceRule = new Tag(new Entity\Tag, 1);
        $this->assertInstanceOf('inklabs\kommerce\Entity\Tag', $priceRule->getTag());
    }
}
