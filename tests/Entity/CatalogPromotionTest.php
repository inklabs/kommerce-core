<?php
namespace inklabs\kommerce\Entity;

use DateTime;
use inklabs\kommerce\tests\Helper\TestCase\EntityTestCase;
use inklabs\kommerce\Lib\UuidInterface;

class CatalogPromotionTest extends EntityTestCase
{
    public function testCreateDefaults()
    {
        $catalogPromotion = new CatalogPromotion;

        $this->assertTrue($catalogPromotion->getId() instanceof UuidInterface);
        $this->assertTrue($catalogPromotion->getCreated() instanceof DateTime);
        $this->assertSame('d', $catalogPromotion->getCode());
        $this->assertSame(null, $catalogPromotion->getTag());
    }

    public function testCreate()
    {
        $tag = $this->dummyData->getTag();

        $catalogPromotion = new CatalogPromotion;
        $catalogPromotion->setCode('20PCTOFF');
        $catalogPromotion->setValue(20);
        $catalogPromotion->setTag($tag);

        $this->assertEntityValid($catalogPromotion);
        $this->assertSame('20PCTOFF', $catalogPromotion->getCode());
        $this->assertSame($tag, $catalogPromotion->getTag());
    }

    public function testIsTagValid()
    {
        $tag = $this->dummyData->getTag();

        $product = $this->dummyData->getProduct();
        $product->addTag($tag);

        $catalogPromotion = new CatalogPromotion;
        $catalogPromotion->setCode('20PCTOFF');
        $catalogPromotion->setTag($tag);

        $this->assertTrue($catalogPromotion->isTagValid($product));
    }

    public function testIsTagValidWithNullTag()
    {
        $product = $this->dummyData->getProduct();

        $catalogPromotion = new CatalogPromotion;
        $catalogPromotion->setCode('20PCTOFF');

        $this->assertTrue($catalogPromotion->isTagValid($product));
    }

    public function testIsTagValidWithNonMatchingTag()
    {
        $product = $this->dummyData->getProduct();

        $catalogPromotion = new CatalogPromotion;
        $catalogPromotion->setCode('20PCTOFF');
        $catalogPromotion->setTag(new Tag);

        $this->assertFalse($catalogPromotion->isTagValid($product));
    }

    public function testIsValid()
    {
        $product = $this->dummyData->getProduct();

        $catalogPromotion = new CatalogPromotion;
        $catalogPromotion->setCode('20PCTOFF');

        $this->assertTrue($catalogPromotion->isValid(new DateTime, $product));
    }
}
