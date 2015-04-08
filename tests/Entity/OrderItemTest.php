<?php
namespace inklabs\kommerce\Entity;

use Symfony\Component\Validator\Validation;

class OrderItemTest extends \PHPUnit_Framework_TestCase
{
    public function testCreate()
    {
        $catalogPromotion = new CatalogPromotion;
        $catalogPromotion->setName('20% OFF Everything');
        $catalogPromotion->setType(Promotion::TYPE_PERCENT);
        $catalogPromotion->setValue(20);

        $productQuantityDiscount = new ProductQuantityDiscount;
        $productQuantityDiscount->setType(Promotion::TYPE_EXACT);
        $productQuantityDiscount->setQuantity(2);
        $productQuantityDiscount->setValue(100);

        $optionProductQuantityDiscount = new ProductQuantityDiscount;
        $optionProductQuantityDiscount->setType(Promotion::TYPE_FIXED);
        $optionProductQuantityDiscount->setQuantity(2);
        $optionProductQuantityDiscount->setValue(100);

        $product = new Product;
        $product->setSku('sku1');
        $product->setname('test name');
        $product->setUnitPrice(500);
        $product->setQuantity(10);
        $product->addProductQuantityDiscount($productQuantityDiscount);

        $product2 = new Product;
        $product2->setSku('sku2');
        $product2->setUnitPrice(400);
        $product2->addProductQuantityDiscount($optionProductQuantityDiscount);


        $option = new Option;
        $option->setName('Test Option');

        $optionValue = new OptionValue($option);
        $optionValue->setProduct($product2);

        $optionProduct = new OrderItemOptionValue($optionValue);

        $price = new Price;
        $price->origUnitPrice = 1;
        $price->unitPrice = 1;
        $price->origQuantityPrice = 1;
        $price->quantityPrice = 1;
        $price->addCatalogPromotion($catalogPromotion);
        $price->addProductQuantityDiscount($productQuantityDiscount);
        $price->addProductQuantityDiscount($optionProductQuantityDiscount);

        $orderItem = new OrderItem;
        $orderItem->setProduct($product);
        $orderItem->setQuantity(2);
        $orderItem->setPrice($price);
        $orderItem->addOrderItemOptionValue($optionProduct);

        $order = new Order;
        $order->addItem($orderItem);
        $order->setTotal(new CartTotal);

        $validator = Validation::createValidatorBuilder()
            ->addMethodMapping('loadValidatorMetadata')
            ->getValidator();

        $this->assertEmpty($validator->validate($orderItem));
        $this->assertSame(2, $orderItem->getQuantity());
        $this->assertSame('sku1-sku2', $orderItem->getSku());
        $this->assertSame('test name', $orderItem->getName());
        $this->assertSame(
            '20% OFF Everything, Buy 2 or more for $1.00 each, Buy 2 or more for $1.00 off',
            $orderItem->getDiscountNames()
        );
        $this->assertSame(null, $orderItem->getId());
        $this->assertTrue($orderItem->getOrder() instanceof Order);
        $this->assertTrue($orderItem->getPrice() instanceof Price);
        $this->assertTrue($orderItem->getProduct() instanceof Product);
        $this->assertTrue($orderItem->getOrderItemOptionValues()[0] instanceof OrderItemOptionValue);
        $this->assertTrue($orderItem->getCatalogPromotions()[0] instanceof CatalogPromotion);
        $this->assertTrue($orderItem->getProductQuantityDiscounts()[0] instanceof ProductQuantityDiscount);
        $this->assertTrue($orderItem->getView() instanceof View\Orderitem);
    }

    public function testCreateWithCustomItem()
    {
        $price = new Price;
        $price->origUnitPrice = 1;
        $price->unitPrice = 1;
        $price->origQuantityPrice = 1;
        $price->quantityPrice = 1;

        $orderItem = new OrderItem;
        $orderItem->setSku('NONE');
        $orderItem->setName('Free Entry Line Item');
        $orderItem->setQuantity(3);
        $orderItem->setPrice($price);

        $order = new Order;
        $order->addItem($orderItem);
        $order->setTotal(new CartTotal);

        $validator = Validation::createValidatorBuilder()
            ->addMethodMapping('loadValidatorMetadata')
            ->getValidator();

        $this->assertEmpty($validator->validate($orderItem));
        $this->assertSame(3, $orderItem->getQuantity());
        $this->assertSame('NONE', $orderItem->getSku());
        $this->assertSame('Free Entry Line Item', $orderItem->getName());
        $this->assertSame('', $orderItem->getDiscountNames());
        $this->assertSame(null, $orderItem->getId());
        $this->assertTrue($orderItem instanceof OrderItem);
    }
}
