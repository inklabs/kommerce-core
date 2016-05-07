<?php
namespace inklabs\kommerce\Entity;

use inklabs\kommerce\Exception\AttachmentException;
use inklabs\kommerce\Lib\Pricing;
use inklabs\kommerce\tests\Helper\TestCase\EntityTestCase;

class CartItemTest extends EntityTestCase
{
    public function testCreateDefaults()
    {
        $cartItem = new CartItem;

        $this->assertSame(null, $cartItem->getQuantity());
        $this->assertSame(null, $cartItem->getProduct());
        $this->assertSame(null, $cartItem->getCart());
        $this->assertSame(0, count($cartItem->getCartItemOptionProducts()));
        $this->assertSame(0, count($cartItem->getCartItemOptionValues()));
        $this->assertSame(0, count($cartItem->getCartItemTextOptionValues()));
        $this->assertSame(0, count($cartItem->getAttachments()));
    }

    public function testCreate()
    {
        $pricing = $this->dummyData->getPricing();
        $cart = $this->dummyData->getCart();
        $cartItemOptionProduct = $this->dummyData->getCartItemOptionProduct();
        $cartItemOptionValue = $this->dummyData->getCartItemOptionValue();
        $cartItemTextOptionValue = $this->dummyData->getCartItemTextOptionValue();
        $product = $this->dummyData->getProduct();

        $product->setShippingWeight(1);
        $product->setSku('P1');

        $cartItemOptionProduct->getOptionProduct()->getProduct()->setSku('OP1');
        $cartItemOptionProduct->getOptionProduct()->getProduct()->setShippingWeight(3);

        $cartItemOptionValue->getOptionValue()->setSku('OV1');
        $cartItemOptionValue->getOptionValue()->setShippingWeight(5);

        $cartItem = new CartItem;
        $cartItem->setProduct($product);
        $cartItem->setQuantity(2);
        $cartItem->setCart($cart);
        $cartItem->addCartItemOptionProduct($cartItemOptionProduct);
        $cartItem->addCartItemOptionValue($cartItemOptionValue);
        $cartItem->addCartItemTextOptionValue($cartItemTextOptionValue);

        $this->assertEntityValid($cartItem);
        $this->assertTrue($cartItem instanceof CartItem);
        $this->assertTrue($cartItem->getPrice($pricing) instanceof Price);
        $this->assertSame(2, $cartItem->getQuantity());
        $this->assertSame('P1-OP1-OV1', $cartItem->getFullSku());
        $this->assertSame(18, $cartItem->getShippingWeight());
        $this->assertSame($cart, $cartItem->getCart());
        $this->assertSame($cartItemOptionProduct, $cartItem->getCartItemOptionProducts()[0]);
        $this->assertSame($cartItemOptionValue, $cartItem->getCartItemOptionValues()[0]);
        $this->assertSame($cartItemTextOptionValue, $cartItem->getCartItemTextOptionValues()[0]);
    }

    public function testClone()
    {
        $cartItem = $this->dummyData->getCartItemFull();
        $newCartItem = clone $cartItem;

        $this->assertNotSame($cartItem, $newCartItem);

        $this->assertNotSame(
            $cartItem->getCartItemOptionProducts()[0],
            $newCartItem->getCartItemOptionProducts()[0]
        );

        $this->assertNotSame(
            $cartItem->getCartItemOptionValues()[0],
            $newCartItem->getCartItemOptionValues()[0]
        );

        $this->assertNotSame(
            $cartItem->getCartItemTextOptionValues()[0],
            $newCartItem->getCartItemTextOptionValues()[0]
        );
    }

    public function testGetOrderItem()
    {
        $cartItem = $this->dummyData->getCartItemFull();
        $orderItem = $cartItem->getOrderItem(new Pricing);

        $this->assertTrue($orderItem instanceof OrderItem);
        $this->assertTrue($orderItem->getProduct() instanceof Product);
        $this->assertSame(2, $orderItem->getQuantity());
        $this->assertTrue($orderItem->getPrice() instanceof Price);
        $this->assertTrue($orderItem->getOrderItemOptionProducts()[0] instanceof OrderItemOptionProduct);
        $this->assertTrue($orderItem->getOrderItemOptionValues()[0] instanceof OrderItemOptionValue);
        $this->assertTrue($orderItem->getOrderItemTextOptionValues()[0] instanceof OrderItemTextOptionValue);
    }

    public function testGetPriceWithOptionProductsAndValuesRetainsCatalogPromotionsAndProductQuantityDiscounts()
    {
        $cartItem = $this->dummyData->getCartItemFull();
        $pricing = $this->dummyData->getPricing();

        $price = $cartItem->getPrice($pricing);

        $this->assertSame(1, count($price->getCatalogPromotions()));
        $this->assertSame(1, count($price->getProductQuantityDiscounts()));
    }

    public function testAddRemoveAttachmentViaProduct()
    {
        $attachment = $this->dummyData->getAttachment();
        $product = $this->dummyData->getProduct();
        $product->enableAttachments();
        $cartItem = $this->dummyData->getCartItem($product);
        $cartItem->addAttachment($attachment);

        $this->assertSame($attachment, $cartItem->getAttachments()[0]);

        $cartItem->removeAttachment($attachment);

        $this->assertSame(0, count($cartItem->getAttachments()));
    }

    public function testAddAttachmentViaTag()
    {
        $tag = $this->dummyData->getTag();
        $tag->enableAttachments();

        $product = $this->dummyData->getProduct();
        $product->addTag($tag);
        $product->disableAttachments();

        $attachment = $this->dummyData->getAttachment();

        $cartItem = $this->dummyData->getCartItem($product);
        $cartItem->addAttachment($attachment);

        $this->assertSame($attachment, $cartItem->getAttachments()[0]);
    }

    public function testAddAttachmentFails()
    {
        $tag = $this->dummyData->getTag();
        $tag->disableAttachments();

        $product = $this->dummyData->getProduct();
        $product->addTag($tag);
        $product->disableAttachments();

        $attachment = $this->dummyData->getAttachment();

        $cartItem = $this->dummyData->getCartItem($product);

        $this->setExpectedException(
            AttachmentException::class,
            'Attachment not allowed'
        );

        $cartItem->addAttachment($attachment);
    }
}
