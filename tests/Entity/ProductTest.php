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

        $this->tag = new Tag;
        $this->tag->setName('Test Tag');
        $this->product->addTag($this->tag);

        $this->price = new Price;
        $this->product->setPriceObj($this->price);

        $this->image = new Image;
        $this->image->setPath('http://lorempixel.com/400/200/');
        $this->image->setWidth(400);
        $this->image->setHeight(200);
        $this->image->setSortOrder(0);
        $this->product->addImage($this->image);

        $reflection = new \ReflectionClass('inklabs\kommerce\Entity\View\Product');
        $this->expectedView = $reflection->newInstanceWithoutConstructor();
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

    public function testaddProductQuantityDiscount()
    {
        $this->product = new Product;
        $this->product->addProductQuantityDiscount(new ProductQuantityDiscount);

        $this->assertEquals(1, count($this->product->getQuantityDiscounts()));
    }

    public function testGetView()
    {
        $this->expectedView->id                  = $this->product->getId();
        $this->expectedView->encodedId           = Service\BaseConvert::encode($this->product->getId());
        $this->expectedView->sku                 = $this->product->getSku();
        $this->expectedView->name                = $this->product->getName();
        $this->expectedView->price               = $this->product->getPrice();
        $this->expectedView->quantity            = $this->product->getQuantity();
        $this->expectedView->isInventoryRequired = $this->product->getIsInventoryRequired();
        $this->expectedView->isPriceVisible      = $this->product->getIsPriceVisible();
        $this->expectedView->isActive            = $this->product->getIsActive();
        $this->expectedView->isVisible           = $this->product->getIsVisible();
        $this->expectedView->isTaxable           = $this->product->getIsTaxable();
        $this->expectedView->isShippable         = $this->product->getIsShippable();
        $this->expectedView->shippingWeight      = $this->product->getShippingWeight();
        $this->expectedView->description         = $this->product->getDescription();
        $this->expectedView->rating              = $this->product->getRating();
        $this->expectedView->defaultImage        = $this->product->getDefaultImage();
        $this->expectedView->created             = $this->product->getCreated();
        $this->expectedView->isInStock           = $this->product->inStock();

        $this->expectedView = $this->expectedView->export();
        $productView = $this->product->getView()->export();

        $this->assertEquals($this->expectedView, $productView);
    }

    public function testGetViewWithAllData()
    {
        $this->expectedView->id                  = $this->product->getId();
        $this->expectedView->encodedId           = Service\BaseConvert::encode($this->product->getId());
        $this->expectedView->sku                 = $this->product->getSku();
        $this->expectedView->name                = $this->product->getName();
        $this->expectedView->price               = $this->product->getPrice();
        $this->expectedView->quantity            = $this->product->getQuantity();
        $this->expectedView->isInventoryRequired = $this->product->getIsInventoryRequired();
        $this->expectedView->isPriceVisible      = $this->product->getIsPriceVisible();
        $this->expectedView->isActive            = $this->product->getIsActive();
        $this->expectedView->isVisible           = $this->product->getIsVisible();
        $this->expectedView->isTaxable           = $this->product->getIsTaxable();
        $this->expectedView->isShippable         = $this->product->getIsShippable();
        $this->expectedView->shippingWeight      = $this->product->getShippingWeight();
        $this->expectedView->description         = $this->product->getDescription();
        $this->expectedView->rating              = $this->product->getRating();
        $this->expectedView->defaultImage        = $this->product->getDefaultImage();
        $this->expectedView->created             = $this->product->getCreated();
        $this->expectedView->priceObj            = $this->product->getPriceObj()->getView()->export();
        $this->expectedView->isInStock           = $this->product->inStock();
        $this->expectedView->tags                = [$this->tag->getView()->withAllData()->export()];
        $this->expectedView->images              = [$this->image->getView()->withAllData()->export()];

        $this->expectedView = $this->expectedView->export();
        $productView = $this->product->getView()->withAllData()->export();

        $this->assertEquals($this->expectedView, $productView);
    }
}
