<?php
namespace inklabs\kommerce\Entity;

class CartPriceRuleTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->productShirt = new Product;
        $this->productShirt->setSku('TS-NAVY-LG');
        $this->productShirt->setName('Navy T-shirt (large)');
        $this->productShirt->setPrice(1200);

        $this->productPoster = new Product;
        $this->productPoster->setSku('PST-CKN');
        $this->productPoster->setName('Citizen Kane (1941) Poster');
        $this->productPoster->setPrice(500);

        $this->cartPriceRule = new CartPriceRule;
        $this->cartPriceRule->setName('Buy a Shirt get a FREE poster');
        $this->cartPriceRule->setStart(new \DateTime('2014-01-01', new \DateTimeZone('UTC')));
        $this->cartPriceRule->setEnd(new \DateTime('2014-12-31', new \DateTimeZone('UTC')));
        $this->cartPriceRule->addItem(new CartPriceRuleItem($this->productShirt, 1));
        $this->cartPriceRule->addItem(new CartPriceRuleItem($this->productPoster, 1));
        $this->cartPriceRule->addDiscount(new CartPriceRuleDiscount($this->productPoster, 1));
    }

    public function testGetters()
    {
        $this->assertEquals(2, count($this->cartPriceRule->getItems()));
        $this->assertEquals(1, count($this->cartPriceRule->getDiscounts()));
    }
}
