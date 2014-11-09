<?php
namespace inklabs\kommerce\Entity;

class CatalogPromotionTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->tag = new Tag;
        $this->tag->setId(1);
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

        $reflection = new \ReflectionClass('inklabs\kommerce\Entity\View\CatalogPromotion');
        $this->expected = $reflection->newInstanceWithoutConstructor();
    }

    // public function testGetView()
    // {
    //     $this->expected->name             = $this->catalogPromotion->getName();
    //     $this->expected->discountType     = $this->catalogPromotion->getDiscountType();
    //     $this->expected->value            = $this->catalogPromotion->getValue();
    //     $this->expected->redemptions      = $this->catalogPromotion->getRedemptions();
    //     $this->expected->maxRedemptions   = $this->catalogPromotion->getMaxRedemptions();
    //     $this->expected->start            = $this->catalogPromotion->getStart();
    //     $this->expected->end              = $this->catalogPromotion->getEnd();
    //     $this->expected->created          = $this->catalogPromotion->getCreated();
    //     $this->expected->updated          = $this->catalogPromotion->getUpdated();
    //     $this->expected->flagFreeShipping = $this->catalogPromotion->getFlagFreeShipping();
    //     $this->expected->code             = $this->catalogPromotion->getCode();
    //
    //     $this->expected = $this->expected->export();
    //
    //     $this->assertEquals($this->expected, $this->catalogPromotion->getView()->export());
    // }

    // public function testGetViewWithAllData()
    // {
    //     $this->expected->name             = $this->catalogPromotion->getName();
    //     $this->expected->discountType     = $this->catalogPromotion->getDiscountType();
    //     $this->expected->value            = $this->catalogPromotion->getValue();
    //     $this->expected->redemptions      = $this->catalogPromotion->getRedemptions();
    //     $this->expected->maxRedemptions   = $this->catalogPromotion->getMaxRedemptions();
    //     $this->expected->start            = $this->catalogPromotion->getStart();
    //     $this->expected->end              = $this->catalogPromotion->getEnd();
    //     $this->expected->created          = $this->catalogPromotion->getCreated();
    //     $this->expected->updated          = $this->catalogPromotion->getUpdated();
    //     $this->expected->flagFreeShipping = $this->catalogPromotion->getFlagFreeShipping();
    //     $this->expected->code             = $this->catalogPromotion->getCode();
    //
    //     $this->expected->tag = $this->catalogPromotion
    //         ->getTag()
    //         ->getView()
    //         ->withAllData()
    //         ->export();
    //
    //     $this->expected = $this->expected->export();
    //
    //     $this->assertEquals($this->expected, $this->catalogPromotion->getView()->withAllData()->export());
    // }

    public function testIsTagValid()
    {
        $date = new \DateTime('2014-02-01', new \DateTimeZone('UTC'));

        $product = new Product;
        $product->setSku('TST101');
        $product->setName('Test Product');
        $product->setUnitPrice(500);
        $product->addTag($this->tag);

        $this->assertTrue($this->catalogPromotion->isValid($date, $product));
    }

    public function testIsValid()
    {
        $tag2 = new Tag;
        $tag2->setId(2);
        $tag2->setName('Test Tag 2');

        $date = new \DateTime('2014-02-01', new \DateTimeZone('UTC'));

        $product = new Product;
        $product->setSku('TST101');
        $product->setName('Test Product');
        $product->setUnitPrice(500);

        $this->assertFalse($this->catalogPromotion->isTagValid($product));

        $product->addTag($tag2);
        $this->assertFalse($this->catalogPromotion->isTagValid($product));

        $product->addTag($this->tag);
        $this->assertTrue($this->catalogPromotion->isTagValid($product));
    }
}
