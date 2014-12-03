<?php
namespace inklabs\kommerce\Entity\View;

use inklabs\kommerce\Entity as Entity;

class CatalogPromotionTest extends \PHPUnit_Framework_TestCase
{
    public function testCreate()
    {
        $entityCatalogPromotion = new Entity\CatalogPromotion;
        $entityCatalogPromotion->setTag(new Entity\Tag);

        $catalogPromotion = CatalogPromotion::factory($entityCatalogPromotion)
            ->withAllData()
            ->export();

        $this->assertInstanceOf('inklabs\kommerce\Entity\View\Tag', $catalogPromotion->tag);
    }
}
