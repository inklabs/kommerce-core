<?php
namespace inklabs\kommerce;

class CartPriceRuleTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->product_shirt = new Entity\Product;
        $this->product_shirt->setSku('TS-NAVY-LG');
        $this->product_shirt->setName('Navy T-shirt (large)');
        $this->product_shirt->setPrice(1200);

        $this->product_poster = new Entity\Product;
        $this->product_poster->setSku('PST-CKN');
        $this->product_poster->setName('Citizen Kane (1941) Poster');
        $this->product_poster->setPrice(500);

        $this->cartPriceRule = new Entity\CartPriceRule;
        $this->cartPriceRule->setName('Buy a Shirt get a FREE poster');
        $this->cartPriceRule->setStart(new \DateTime('2014-01-01', new \DateTimeZone('UTC')));
        $this->cartPriceRule->setEnd(new \DateTime('2014-12-31', new \DateTimeZone('UTC')));
        $this->cartPriceRule->addItem(new Entity\CartPriceRuleItem($this->product_shirt, 1));
        $this->cartPriceRule->addItem(new Entity\CartPriceRuleItem($this->product_poster, 1));
        $this->cartPriceRule->addDiscount(new Entity\CartPriceRuleDiscount($this->product_poster, 1));
    }

    public function testGetters()
    {
        $this->assertEquals(2, count($this->cartPriceRule->getItems()));
        $this->assertEquals(1, count($this->cartPriceRule->getDiscounts()));
    }
}
