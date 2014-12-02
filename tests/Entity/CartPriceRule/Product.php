<?php
namespace inklabs\kommerce\Entity\CartPriceRule;

use inklabs\kommerce\Entity as Entity;

class ProductTest extends \PHPUnit_Framework_TestCase
{
    private function getProduct($id)
    {
        $product = new Entity\Product();
        $product->setId($id);
        return $product;
    }

    public function testProductMatches()
    {
        $product1 = $this->getProduct(1);

        $cartItem = new Entity\CartItem($product1, 1);
        $priceRule = new Product($product1, 1);

        $this->assertTrue($priceRule->matches($cartItem));
    }

    public function testProductMatchesWithLargerQuantity()
    {
        $product1 = $this->getProduct(1);

        $cartItem = new Entity\CartItem($product1, 2);
        $priceRule = new Product($product1, 1);

        $this->assertTrue($priceRule->matches($cartItem));
    }

    public function testProductDoesNotMatch()
    {
        $product1 = $this->getProduct(1);
        $product2 = $this->getProduct(2);

        $cartItem = new Entity\CartItem($product1, 1);
        $priceRule = new Product($product2, 1);

        $this->assertFalse($priceRule->matches($cartItem));
    }

    public function testProductDoesNotMatchByQuantity()
    {
        $product1 = $this->getProduct(1);

        $cartItem = new Entity\CartItem($product1, 1);
        $priceRule = new Product($product1, 2);

        $this->assertFalse($priceRule->matches($cartItem));
    }

    public function testGetters()
    {
        $product1 = $this->getProduct(1);
        $priceRule = new Product($product1, 1);
        $this->assertInstanceOf('inklabs\kommerce\Entity\Product', $priceRule->getProduct());
    }
}
