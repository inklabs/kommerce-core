<?php
namespace inklabs\kommerce\Entity;

use inklabs\kommerce\Service;
use inklabs\kommerce\View;

class CartItemTest extends \PHPUnit_Framework_TestCase
{
    public function testCreateCartItem()
    {
        $product = new Product;
        $product->setSku('PRD1');
        $product->setUnitPrice(100);
        $product->setShippingWeight(10);

        $optionValue = $this->getMockedOptionValue();

        $cartItem = new CartItem($product, 2);
        $cartItem->setId(1);
        $cartItem->setOptionValues([$optionValue]);

        $pricing = new Service\Pricing;

        $this->assertSame(1, $cartItem->getId());
        $this->assertSame(2, $cartItem->getQuantity());
        $this->assertSame('PRD1-OPT2', $cartItem->getFullSku());
        $this->assertTrue($cartItem->getOptionValues()[0] instanceof OptionValue\OptionValueInterface);
        $this->assertTrue($cartItem->getPrice($pricing) instanceof Price);
        $this->assertSame(240, $cartItem->getPrice($pricing)->quantityPrice);
        $this->assertSame(24, $cartItem->getShippingWeight());
        $this->assertTrue($cartItem->getView() instanceof View\CartItem);
    }

    /**
     * @return OptionValue\OptionValueInterface
     */
    private function getMockedOptionValue()
    {
        $price = new Price;
        $price->unitPrice = 20;
        $price->quantityPrice = 40;

        $optionType = \Mockery::mock('inklabs\kommerce\Entity\OptionType\OptionTypeInterface');
        $optionType->shouldReceive('getName')->andReturn('Test Option Type Name');

        $optionValue = \Mockery::mock('inklabs\kommerce\Entity\OptionValue\OptionValueInterface');
        $optionValue->shouldReceive('getSku')->andReturn('OPT2');
        $optionValue->shouldReceive('getName')->andReturn('Test Option Value Name');
        $optionValue->shouldReceive('getPrice')->andReturn($price);
        $optionValue->shouldReceive('getShippingWeight')->andReturn(2);
        $optionValue->shouldReceive('getOptionType')->andReturn($optionType);
        return $optionValue;
    }

    public function testSetProductAndQuantity()
    {
        $cartItem = new CartItem(new Product, 2);
        $cartItem->setProduct(new Product);
        $cartItem->setQuantity(3);
        $this->assertTrue($cartItem->getProduct() instanceof Product);
        $this->assertSame(3, $cartItem->getQuantity());
    }

    public function testGetOrderItem()
    {
        $optionValue = $this->getMockedOptionValue();

        $cartItem = new CartItem(new Product, 1);
        $cartItem->addOptionValue($optionValue);

        $this->assertTrue($cartItem->getOrderItem(new Service\Pricing) instanceof OrderItem);
    }
}
