<?php
namespace inklabs\kommerce\Entity\CartPriceRuleDiscount;

use inklabs\kommerce\Entity as Entity;

class ProductTest extends \PHPUnit_Framework_TestCase
{
    public function testCreate()
    {
        $priceRule = new Product(new Entity\Product, 1);
        $this->assertInstanceOf('inklabs\kommerce\Entity\Product', $priceRule->getProduct());
    }
}
