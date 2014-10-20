<?php
namespace inklabs\kommerce\Entity;

use inklabs\kommerce\Service as Service;

class ProductTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->product = new Product;
        $this->product->setSku('TST101');
        $this->product->setName('Test Product');
        $this->product->setPrice(500);
        $this->product->setQuantity(10);
        // $this->product->setProduct_group_id(null);
        $this->product->setIsInventoryRequired(true);
        $this->product->setIsPriceVisible(true);
        $this->product->setIsActive(true);
        $this->product->setIsVisible(true);
        $this->product->setIsTaxable(true);
        $this->product->setIsShippable(true);
        $this->product->setShippingWeight(16);
        $this->product->setDescription('Test product description');
        $this->product->setRating(null);
        $this->product->setDefaultImage(null);
        $this->product->setCreated(new \DateTime('now', new \DateTimeZone('UTC')));

        $this->tag = new Tag;
        $this->tag->setName('Test Tag');
        $this->product->addTag($this->tag);

        $this->price = new Price;
        $this->product->setPriceObj($this->price);
    }

    public function testGetData()
    {
        $expected = new \stdClass;
        $expected->id                  = $this->product->getId();
        $expected->encodedId           = Service\BaseConvert::encode($this->product->getId());
        $expected->sku                 = $this->product->getSku();
        $expected->name                = $this->product->getName();
        $expected->price               = $this->product->getPrice();
        $expected->quantity            = $this->product->getQuantity();
        $expected->isInventoryRequired = $this->product->getIsInventoryRequired();
        $expected->isPriceVisible      = $this->product->getIsPriceVisible();
        $expected->isActive            = $this->product->getIsActive();
        $expected->isVisible           = $this->product->getIsVisible();
        $expected->isTaxable           = $this->product->getIsTaxable();
        $expected->isShippable         = $this->product->getIsShippable();
        $expected->shippingWeight      = $this->product->getShippingWeight();
        $expected->description         = $this->product->getDescription();
        $expected->rating              = $this->product->getRating();
        $expected->defaultImage        = $this->product->getDefaultImage();
        $expected->priceObj            = $this->product->getPriceObj()->getData();
        $expected->isInStock           = $this->product->inStock();

        $this->assertEquals($expected, $this->product->getData());
    }

    public function testGetAllData()
    {
        $expected = new \stdClass;
        $expected->id                  = $this->product->getId();
        $expected->encodedId           = Service\BaseConvert::encode($this->product->getId());
        $expected->sku                 = $this->product->getSku();
        $expected->name                = $this->product->getName();
        $expected->price               = $this->product->getPrice();
        $expected->quantity            = $this->product->getQuantity();
        $expected->isInventoryRequired = $this->product->getIsInventoryRequired();
        $expected->isPriceVisible      = $this->product->getIsPriceVisible();
        $expected->isActive            = $this->product->getIsActive();
        $expected->isVisible           = $this->product->getIsVisible();
        $expected->isTaxable           = $this->product->getIsTaxable();
        $expected->isShippable         = $this->product->getIsShippable();
        $expected->shippingWeight      = $this->product->getShippingWeight();
        $expected->description         = $this->product->getDescription();
        $expected->rating              = $this->product->getRating();
        $expected->defaultImage        = $this->product->getDefaultImage();
        $expected->priceObj            = $this->product->getPriceObj()->getAllData();
        $expected->tags                = [$this->tag->getData()];
        $expected->isInStock           = $this->product->inStock();

        $this->assertEquals($expected, $this->product->getAllData());
    }

    public function testRequiredInStock()
    {
        $this->product->setIsInventoryRequired(true);

        $this->product->setQuantity(0);
        $this->assertFalse($this->product->inStock());

        $this->product->setQuantity(1);
        $this->assertTrue($this->product->inStock());
    }

    public function testNotRequiredInStock()
    {
        $this->product->setIsInventoryRequired(false);

        $this->assertTrue($this->product->inStock());
    }

    public function testGetRating()
    {
        $this->product->setRating(150);
        $this->assertSame(1.5, $this->product->getRating());

        $this->product->setRating(500);
        $this->assertSame(5, $this->product->getRating());
    }

    public function testaddQuantityDiscount()
    {
        $this->product = new Product;
        $this->product->addQuantityDiscount(new ProductQuantityDiscount);

        $this->assertEquals(1, count($this->product->getQuantityDiscounts()));
    }
}
