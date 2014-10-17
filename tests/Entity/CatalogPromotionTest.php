<?php
namespace inklabs\kommerce;

class CatalogPromotionTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->tag = new Entity\Tag;
        $this->tag->setName('Test Tag');

        $this->catalogPromotion = new Entity\CatalogPromotion;
        $this->catalogPromotion->setCode('20PCTOFF');
        $this->catalogPromotion->setName('20% Off');
        $this->catalogPromotion->setDiscountType('percent');
        $this->catalogPromotion->setValue(20);
        $this->catalogPromotion->setTag($this->tag);
        $this->catalogPromotion->setFlagFreeShipping(false);
        $this->catalogPromotion->setStart(new \DateTime('2014-01-01', new \DateTimeZone('UTC')));
        $this->catalogPromotion->setEnd(new \DateTime('2014-12-31', new \DateTimeZone('UTC')));
    }

    public function testGetters()
    {
        $this->assertEquals(null, $this->catalogPromotion->getId());
        $this->assertEquals('20PCTOFF', $this->catalogPromotion->getCode());
        $this->assertEquals($this->tag, $this->catalogPromotion->getTag());
        $this->assertEquals(false, $this->catalogPromotion->getFlagFreeShipping());
    }

    public function testIsTagValid()
    {
        $date = new \DateTime('2014-02-01', new \DateTimeZone('UTC'));

        $product = new Entity\Product;
        $product->setSku('TST101');
        $product->setName('Test Product');
        $product->setPrice(500);
        $product->addTag($this->tag);

        $this->assertTrue($this->catalogPromotion->isValid($date, $product));
    }

    public function testIsValid()
    {
        $tag2 = new Entity\Tag;
        $tag2->setName('Test Tag 2');

        $date = new \DateTime('2014-02-01', new \DateTimeZone('UTC'));

        $product = new Entity\Product;
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
