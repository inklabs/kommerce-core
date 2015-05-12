<?php
namespace inklabs\kommerce\View;

use inklabs\kommerce\Entity;
use inklabs\kommerce\Lib;

class ProductTest extends \PHPUnit_Framework_TestCase
{
    public function testCreate()
    {
        $tag = new Entity\Tag;
        $tag->addImage(new Entity\Image);

        $productAttribute = new Entity\ProductAttribute;
        $productAttribute->setAttribute(new Entity\Attribute);
        $productAttribute->setAttributeValue(new Entity\AttributeValue);

        $entityProduct = new Entity\Product;
        $entityProduct->addTag($tag);
        $entityProduct->addImage(new Entity\Image);
        $entityProduct->addProductAttribute($productAttribute);

        $productQuantityDiscount = new Entity\ProductQuantityDiscount;
        $productQuantityDiscount->setType(Entity\Promotion::TYPE_EXACT);
        $productQuantityDiscount->setQuantity(2);
        $productQuantityDiscount->setValue(400);

        $entityProduct->addProductQuantityDiscount($productQuantityDiscount);

        $optionProduct = new Entity\OptionProduct;
        $optionProduct->setProduct(new Entity\Product);
        $entityProduct->addOptionProduct($optionProduct);

        $product = $entityProduct->getView()
            ->withAllData(new Lib\Pricing)
            ->export();

        $this->assertTrue($product->tags[0] instanceof Tag);
        $this->assertTrue($product->images[0] instanceof Image);
        $this->assertTrue($product->productQuantityDiscounts[0] instanceof ProductQuantityDiscount);
        $this->assertTrue($product->productAttributes[0] instanceof ProductAttribute);
        $this->assertTrue($product->optionProducts[0] instanceof OptionProduct);
        $this->assertTrue($product->price instanceof Price);
    }

    public function testCreateWithTagsOnly()
    {
        $tag = new Entity\Tag;
        $tag->addImage(new Entity\Image);

        $entityProduct = new Entity\Product;
        $entityProduct->addTag($tag);

        $product = $entityProduct->getView()
            ->withTags()
            ->export();

        $this->assertTrue($product->tags[0] instanceof Tag);
    }
}
