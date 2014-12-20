<?php
namespace inklabs\kommerce\Entity;

use inklabs\kommerce\Service\Pricing;

class OrderItemTest extends \PHPUnit_Framework_TestCase
{
    public function testCreate()
    {
        $product = new Product;
        $product->setUnitPrice(500);
        $product->setQuantity(10);

        $pricing = new Pricing;

        $cartItem = new CartItem($product, 2);
        $orderItem = new OrderItem($cartItem, $pricing);

        $order = new Order(new Cart, $pricing);
        $orderItem->setOrder($order);

        $this->assertTrue($orderItem->getPrice() instanceof Price);
        $this->assertEquals('', $orderItem->getDiscountNames());
        $this->assertEquals(null, $orderItem->getId());
        $this->assertTrue($orderItem->getProduct() instanceof Product);
    }

    public function testCreateOrderItemWithDiscounts()
    {
        $catalogPromotion = new CatalogPromotion;
        $catalogPromotion->setName('10% OFF');
        $catalogPromotion->setType('percent');
        $catalogPromotion->setValue(10);

        $productQuantityDiscount = new ProductQuantityDiscount;
        $productQuantityDiscount->setType('exact');
        $productQuantityDiscount->setQuantity(2);
        $productQuantityDiscount->setValue(400);

        $product = new Product;
        $product->setUnitPrice(500);
        $product->setQuantity(10);
        $product->addProductQuantityDiscount($productQuantityDiscount);

        $pricing = new Pricing;
        $pricing->setCatalogPromotions([$catalogPromotion]);
        $pricing->setProductQuantityDiscounts([$productQuantityDiscount]);

        $cartItem = new CartItem($product, 2);
        $orderItem = new OrderItem($cartItem, $pricing);

        $order = new Order(new Cart, $pricing);
        $orderItem->setOrder($order);

        $this->assertTrue($orderItem->getPrice() instanceof Price);
        $this->assertEquals('10% OFF, Buy 2 or more for $4.00 each', $orderItem->getDiscountNames());
        $this->assertEquals(null, $orderItem->getId());
    }
}
