<?php
namespace inklabs\kommerce;

use inklabs\kommerce\Entity\CatalogPromotion;
use inklabs\kommerce\Entity\Product;
use inklabs\kommerce\Entity\Tag;

class CatalogPromotionTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->tag = new Tag;
        $this->tag->setName('Test Tag');

        $this->catalogPromotion = new CatalogPromotion;
        $this->catalogPromotion->setName('20% Off');
        $this->catalogPromotion->setDiscountType('percent');
        $this->catalogPromotion->setValue(20);
        $this->catalogPromotion->setTag($this->tag);
        $this->catalogPromotion->setStart(new \DateTime('2014-01-01', new \DateTimeZone('UTC')));
        $this->catalogPromotion->setEnd(new \DateTime('2014-12-31', new \DateTimeZone('UTC')));
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
