<?php
namespace inklabs\kommerce\Entity;

use DateTime;
use inklabs\kommerce\tests\Helper\DoctrineTestCase;

class CatalogPromotionTest extends DoctrineTestCase
{
    public function testCreate()
    {
        $catalogPromotion = new CatalogPromotion;
        $catalogPromotion->setCode('20PCTOFF');
        $catalogPromotion->setValue(20);
        $catalogPromotion->setTag(new Tag);

        $this->assertEntityValid($catalogPromotion);
        $this->assertSame('20PCTOFF', $catalogPromotion->getCode());
        $this->assertTrue($catalogPromotion->getTag() instanceof Tag);
    }

    public function testIsTagValid()
    {
        $tag = new Tag;
        $tag->setId(1);

        $product = new Product;
        $product->addTag($tag);

        $catalogPromotion = new CatalogPromotion;
        $catalogPromotion->setCode('20PCTOFF');
        $catalogPromotion->setTag($tag);

        $this->assertTrue($catalogPromotion->isTagValid($product));
    }

    public function testIsTagValidWithNullTag()
    {
        $catalogPromotion = new CatalogPromotion;
        $catalogPromotion->setCode('20PCTOFF');

        $this->assertTrue($catalogPromotion->isTagValid(new Product));
    }

    public function testIsTagValidWithNonMatchingTag()
    {
        $catalogPromotion = new CatalogPromotion;
        $catalogPromotion->setCode('20PCTOFF');
        $catalogPromotion->setTag(new Tag);

        $this->assertFalse($catalogPromotion->isTagValid(new Product));
    }

    public function testIsValid()
    {
        $catalogPromotion = new CatalogPromotion;
        $catalogPromotion->setCode('20PCTOFF');

        $this->assertTrue($catalogPromotion->isValid(new DateTime, new Product));
    }
}
