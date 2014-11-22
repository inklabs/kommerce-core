<?php
namespace inklabs\kommerce\Entity\View;

use inklabs\kommerce\Entity as Entity;

class CatalogPromotionTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->catalogPromotion = new Entity\CatalogPromotion;
        $this->catalogPromotion->setName('20% Off');
        $this->catalogPromotion->setDiscountType('percent');
        $this->catalogPromotion->setValue(20);
        $this->catalogPromotion->setStart(new \DateTime('2014-01-01', new \DateTimeZone('UTC')));
        $this->catalogPromotion->setEnd(new \DateTime('2014-12-31', new \DateTimeZone('UTC')));

        $this->tag = new Entity\Tag;
        $this->tag->setName('Test Tag');
        $this->catalogPromotion->setTag($this->tag);

        $this->viewCatalogPromotion = CatalogPromotion::factory($this->catalogPromotion);
    }

    public function testWithAllData()
    {
        $viewCatalogPromotion = $this->viewCatalogPromotion
            ->withAllData()
            ->export();
        $this->assertEquals(20, $viewCatalogPromotion->value);
        $this->assertEquals('Test Tag', $viewCatalogPromotion->tag->name);
    }
}
