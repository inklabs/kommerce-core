<?php
namespace inklabs\kommerce\Entity;

use inklabs\kommerce\Service;
use inklabs\kommerce\View;
use Symfony\Component\Validator\Validation;

class CartItemTest extends \PHPUnit_Framework_TestCase
{
    public function testCreate()
    {
        $cartItem = $this->getCartItem();

        $pricing = new Service\Pricing;

        $validator = Validation::createValidatorBuilder()
            ->addMethodMapping('loadValidatorMetadata')
            ->getValidator();

        $this->assertEmpty($validator->validate($cartItem));
        $this->assertTrue($cartItem instanceof CartItem);
        $this->assertSame(2, $cartItem->getQuantity());
        $this->assertSame('P1-OP1-OV1', $cartItem->getFullSku());
        $this->assertSame(600, $cartItem->getPrice($pricing)->quantityPrice);
        $this->assertSame(60, $cartItem->getShippingWeight());
        $this->assertTrue($cartItem->getCartItemOptionProducts()[0] instanceof CartItemOptionProduct);
        $this->assertTrue($cartItem->getCartItemOptionValues()[0] instanceof CartItemOptionValue);
        $this->assertTrue($cartItem->getCartItemTextOptionValues()[0] instanceof CartItemTextOptionValue);
        $this->assertTrue($cartItem->getPrice($pricing) instanceof Price);
        $this->assertTrue($cartItem->getCart() instanceof Cart);
        $this->assertTrue($cartItem->getView() instanceof View\CartItem);
    }

    public function testGetOrderItem()
    {
        $cartItem = $this->getCartItem();
        $orderItem = $cartItem->getOrderItem(new Service\Pricing);

        $this->assertTrue($orderItem instanceof OrderItem);
        $this->assertTrue($orderItem->getProduct() instanceof Product);
        $this->assertSame(2, $orderItem->getQuantity());
        $this->assertTrue($orderItem->getPrice() instanceof Price);
        $this->assertTrue($orderItem->getOrderItemOptionProducts()[0] instanceof OrderItemOptionProduct);
        $this->assertTrue($orderItem->getOrderItemOptionValues()[0] instanceof OrderItemOptionValue);
        $this->assertTrue($orderItem->getOrderItemTextOptionValues()[0] instanceof OrderItemTextOptionValue);
    }

    private function getCartItem()
    {
        $product = new Product;
        $product->setSku('P1');
        $product->setUnitPrice(100);
        $product->setShippingWeight(10);

        $product2 = new Product;
        $product2->setSku('OP1');
        $product2->setUnitPrice(100);
        $product2->setShippingWeight(10);

        $option1 = new Option;
        $option1->setname('Option 1');

        $optionProduct = new OptionProduct;
        $optionProduct->setOption($option1);
        $optionProduct->setProduct($product2);

        $option2 = new Option;
        $option2->setname('Option 2');

        $optionValue = new OptionValue;
        $optionValue->setOption($option2);
        $optionValue->setSku('OV1');
        $optionValue->setUnitPrice(100);
        $optionValue->setShippingWeight(10);

        $textOption = new TextOption;

        $cartItemOptionProduct = new CartItemOptionProduct;
        $cartItemOptionProduct->setOptionProduct($optionProduct);

        $cartItemOptionValue = new CartItemOptionValue;
        $cartItemOptionValue->setOptionValue($optionValue);

        $cartItemTextOptionValue = new CartItemTextOptionValue;
        $cartItemTextOptionValue->setTextOption($textOption);
        $cartItemTextOptionValue->setTextOptionValue('Happy Birthday');

        $cartItem = new CartItem;
        $cartItem->setProduct($product);
        $cartItem->setQuantity(2);
        $cartItem->setCart(new Cart);
        $cartItem->addCartItemOptionProduct($cartItemOptionProduct);
        $cartItem->addCartItemOptionValue($cartItemOptionValue);
        $cartItem->addCartItemTextOptionValue($cartItemTextOptionValue);

        return $cartItem;
    }
}
