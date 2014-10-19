<?php
namespace inklabs\kommerce\Entity;

class CatalogPromotionTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->tag = new Tag;
        $this->tag->setName('Test Tag');

        $this->catalogPromotion = new CatalogPromotion;
        $this->catalogPromotion->setCode('20PCTOFF');
        $this->catalogPromotion->setName('20% Off');
        $this->catalogPromotion->setDiscountType('percent');
        $this->catalogPromotion->setValue(20);
        $this->catalogPromotion->setTag($this->tag);
        $this->catalogPromotion->setFlagFreeShipping(false);
        $this->catalogPromotion->setStart(new \DateTime('2014-01-01', new \DateTimeZone('UTC')));
        $this->catalogPromotion->setEnd(new \DateTime('2014-12-31', new \DateTimeZone('UTC')));
    }

    public function testGetData()
    {
        $expected = new \stdClass;
        $expected->name             = $this->catalogPromotion->getName();
        $expected->discountType     = $this->catalogPromotion->getDiscountType();
        $expected->value            = $this->catalogPromotion->getValue();
        $expected->redemptions      = $this->catalogPromotion->getRedemptions();
        $expected->maxRedemptions   = $this->catalogPromotion->getMaxRedemptions();
        $expected->start            = $this->catalogPromotion->getStart();
        $expected->end              = $this->catalogPromotion->getEnd();
        $expected->created          = $this->catalogPromotion->getCreated();
        $expected->updated          = $this->catalogPromotion->getUpdated();
        $expected->flagFreeShipping = $this->catalogPromotion->getFlagFreeShipping();
        $expected->code             = $this->catalogPromotion->getCode();

        $this->assertEquals($expected, $this->catalogPromotion->getData());
    }

    public function testGetAllData()
    {
        $expected = new \stdClass;
        $expected->name             = $this->catalogPromotion->getName();
        $expected->discountType     = $this->catalogPromotion->getDiscountType();
        $expected->value            = $this->catalogPromotion->getValue();
        $expected->redemptions      = $this->catalogPromotion->getRedemptions();
        $expected->maxRedemptions   = $this->catalogPromotion->getMaxRedemptions();
        $expected->start            = $this->catalogPromotion->getStart();
        $expected->end              = $this->catalogPromotion->getEnd();
        $expected->created          = $this->catalogPromotion->getCreated();
        $expected->updated          = $this->catalogPromotion->getUpdated();
        $expected->flagFreeShipping = $this->catalogPromotion->getFlagFreeShipping();
        $expected->code             = $this->catalogPromotion->getCode();
        $expected->tag              = $this->catalogPromotion->getTag()->getData();

        $this->assertEquals($expected, $this->catalogPromotion->getAllData());
    }

    public function testIsTagValid()
    {
        $date = new \DateTime('2014-02-01', new \DateTimeZone('UTC'));

        $product = new Product;
        $product->setSku('TST101');
        $product->setName('Test Product');
        $product->setPrice(500);
        $product->addTag($this->tag);

        $this->assertTrue($this->catalogPromotion->isValid($date, $product));
    }

    public function testIsValid()
    {
        $tag2 = new Tag;
        $tag2->setName('Test Tag 2');

        $date = new \DateTime('2014-02-01', new \DateTimeZone('UTC'));

        $product = new Product;
        $product->setSku('TST101');
        $product->setName('Test Product');
        $product->setPrice(500);

        $this->assertFalse($this->catalogPromotion->isTagValid($product));

        $product->addTag($tag2);
        $this->assertFalse($this->catalogPromotion->isTagValid($product));

        $product->addTag($this->tag);
        $this->assertTrue($this->catalogPromotion->isTagValid($product));
    }
}
