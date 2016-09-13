<?php
namespace inklabs\kommerce\Entity;

use DateTime;
use inklabs\kommerce\Exception\AttachmentException;
use inklabs\kommerce\tests\Helper\TestCase\EntityTestCase;
use inklabs\kommerce\Lib\UuidInterface;

class OrderItemTest extends EntityTestCase
{
    public function testCreateDefaults()
    {
        $order = $this->dummyData->getOrder();
        $orderItem = new OrderItem($order);

        $this->assertTrue($orderItem->getId() instanceof UuidInterface);
        $this->assertTrue($orderItem->getCreated() instanceof DateTime);
        $this->assertSame(null, $orderItem->getQuantity());
        $this->assertSame(null, $orderItem->getSku());
        $this->assertSame(null, $orderItem->getName());
        $this->assertSame(null, $orderItem->getDiscountNames());
        $this->assertSame(null, $orderItem->getPrice());
        $this->assertSame(null, $orderItem->getProduct());
        $this->assertSame($order, $orderItem->getOrder());
        $this->assertSame(0, count($orderItem->getOrderItemOptionProducts()));
        $this->assertSame(0, count($orderItem->getOrderItemOptionValues()));
        $this->assertSame(0, count($orderItem->getOrderItemTextOptionValues()));
        $this->assertSame(0, count($orderItem->getCatalogPromotions()));
        $this->assertSame(0, count($orderItem->getProductQuantityDiscounts()));
        $this->assertSame(0, count($orderItem->getAttachments()));
    }

    public function testCreate()
    {
        $catalogPromotion = $this->dummyData->getCatalogPromotion();
        $catalogPromotion->setName('20% OFF Everything');

        $productQuantityDiscount1 = $this->dummyData->getProductQuantityDiscount();
        $productQuantityDiscount1->setType(PromotionType::exact());
        $productQuantityDiscount1->setQuantity(1);
        $productQuantityDiscount1->setValue(100);

        $product = $this->dummyData->getProduct();
        $product->setSku('sku1');
        $product->setName('Test Product');

        $productQuantityDiscount2 = $this->dummyData->getProductQuantityDiscount();
        $productQuantityDiscount2->setType(PromotionType::fixed());
        $productQuantityDiscount2->setQuantity(2);
        $productQuantityDiscount2->setValue(200);

        $price = $this->dummyData->getPrice();
        $price->addCatalogPromotion($catalogPromotion);
        $price->addProductQuantityDiscount($productQuantityDiscount1);
        $price->addProductQuantityDiscount($productQuantityDiscount2);

        $optionProduct = $this->dummyData->getOptionProduct();
        $optionProduct->getProduct()->setSku('OP1');
        $orderItemOptionProduct = $this->dummyData->getOrderItemOptionProduct($optionProduct);

        $optionValue = $this->dummyData->getOptionValue();
        $optionValue->setSku('OV1');
        $orderItemOptionValue = $this->dummyData->getOrderItemOptionValue($optionValue);

        $orderItemTextOptionValue = $this->dummyData->getOrderItemTextOptionValue();

        $order = $this->dummyData->getOrder();

        $orderItem = new OrderItem($order);
        $orderItem->setProduct($product);
        $orderItem->setQuantity(2);
        $orderItem->setPrice($price);
        $orderItem->addOrderItemOptionProduct($orderItemOptionProduct);
        $orderItem->addOrderItemOptionValue($orderItemOptionValue);
        $orderItem->addOrderItemTextOptionValue($orderItemTextOptionValue);

        $this->assertEntityValid($orderItem);
        $this->assertSame(2, $orderItem->getQuantity());
        $this->assertSame('sku1-OP1-OV1', $orderItem->getSku());
        $this->assertSame('Test Product', $orderItem->getName());
        $this->assertSame(
            '20% OFF Everything, Buy 1 or more for $1.00 each, Buy 2 or more for $2.00 off',
            $orderItem->getDiscountNames()
        );
        $this->assertSame($order, $orderItem->getOrder());
        $this->assertSame($product, $orderItem->getProduct());
        $this->assertSame($price, $orderItem->getPrice());
        $this->assertSame($orderItemOptionProduct, $orderItem->getOrderItemOptionProducts()[0]);
        $this->assertSame($orderItemOptionValue, $orderItem->getOrderItemOptionValues()[0]);
        $this->assertSame($orderItemTextOptionValue, $orderItem->getOrderItemTextOptionValues()[0]);
        $this->assertSame($catalogPromotion, $orderItem->getCatalogPromotions()[0]);
        $this->assertSame($productQuantityDiscount1, $orderItem->getProductQuantityDiscounts()[0]);
    }

    public function testCreateWithCustomItem()
    {
        $order = $this->dummyData->getOrder();
        $orderItem = new OrderItem($order);
        $orderItem->setName('Free Entry Line Item');
        $orderItem->setQuantity(3);

        $this->assertEntityValid($orderItem);
        $this->assertSame(3, $orderItem->getQuantity());
        $this->assertSame(null, $orderItem->getSku());
        $this->assertSame('Free Entry Line Item', $orderItem->getName());
    }

    public function testGetQuantityShippingWeight()
    {
        $product1 = $this->dummyData->getProduct();
        $product1->setShippingWeight(1);

        $order = $this->dummyData->getOrder();
        $orderItem = new OrderItem($order);
        $orderItem->setProduct($product1);
        $orderItem->setQuantity(2);

        $this->assertSame(1, $orderItem->getShippingWeight());
        $this->assertSame(2, $orderItem->getQuantityShippingWeight());

        $product2 = $this->dummyData->getProduct();
        $product2->setShippingWeight(3);
        $optionProduct = $this->dummyData->getOptionProduct(null, $product2);
        $orderItemOptionProduct = $this->dummyData->getOrderItemOptionProduct($optionProduct);
        $orderItem->addOrderItemOptionProduct($orderItemOptionProduct);
        $orderItem->addOrderItemOptionProduct($orderItemOptionProduct);

        $this->assertSame(14, $orderItem->getQuantityShippingWeight());

        $optionValue = $this->dummyData->getOptionValue();
        $optionValue->setShippingWeight(5);
        $orderItemOptionValue = $this->dummyData->getOrderItemOptionValue($optionValue);
        $orderItem->addOrderItemOptionValue($orderItemOptionValue);
        $orderItem->addOrderItemOptionValue($orderItemOptionValue);

        $this->assertSame(17, $orderItem->getShippingWeight());
        $this->assertSame(34, $orderItem->getQuantityShippingWeight());
    }

    public function testAddRemoveAttachmentViaProduct()
    {
        $attachment = $this->dummyData->getAttachment();
        $product = $this->dummyData->getProduct();
        $product->enableAttachments();
        $orderItem = $this->dummyData->getOrderItem(null, $product);
        $orderItem->addAttachment($attachment);

        $this->assertSame($attachment, $orderItem->getAttachments()[0]);

        $orderItem->removeAttachment($attachment);

        $this->assertSame(0, count($orderItem->getAttachments()));
    }

    public function testAddAttachmentViaTag()
    {
        $tag = $this->dummyData->getTag();
        $tag->enableAttachments();

        $product = $this->dummyData->getProduct();
        $product->addTag($tag);
        $product->disableAttachments();

        $attachment = $this->dummyData->getAttachment();

        $orderItem = $this->dummyData->getOrderItem(null, $product);
        $orderItem->addAttachment($attachment);

        $this->assertSame($attachment, $orderItem->getAttachments()[0]);
    }

    public function testAddAttachmentFails()
    {
        $tag = $this->dummyData->getTag();
        $tag->disableAttachments();

        $product = $this->dummyData->getProduct();
        $product->addTag($tag);
        $product->disableAttachments();

        $attachment = $this->dummyData->getAttachment();

        $orderItem = $this->dummyData->getOrderItem(null, $product);

        $this->setExpectedException(
            AttachmentException::class,
            'Attachment not allowed'
        );

        $orderItem->addAttachment($attachment);
    }

    public function testAddAttachmentFailsWithNoProduct()
    {
        $attachment = $this->dummyData->getAttachment();

        $orderItem = $this->dummyData->getOrderItemWithoutProduct();

        $this->setExpectedException(
            AttachmentException::class,
            'Attachment not allowed'
        );

        $orderItem->addAttachment($attachment);
    }
}
