<?php
namespace inklabs\kommerce\Entity;

class CatalogPromotionTest extends \PHPUnit_Framework_TestCase
{
    public function testCreate()
    {
        $catalogPromotion = new CatalogPromotion;
        $catalogPromotion->setCode('20PCTOFF');
        $catalogPromotion->setTag(new Tag);

        $this->assertEquals('20PCTOFF', $catalogPromotion->getCode());
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

        $this->assertTrue($catalogPromotion->isValid(new \DateTime, new Product));
    }
}
