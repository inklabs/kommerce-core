<?php
namespace inklabs\kommerce\View;

use inklabs\kommerce\Entity;

class CatalogPromotionTest extends \PHPUnit_Framework_TestCase
{
    public function testCreate()
    {
        $entityCatalogPromotion = new Entity\CatalogPromotion;
        $entityCatalogPromotion->setTag(new Entity\Tag);

        $catalogPromotion = $entityCatalogPromotion->getView()
            ->withAllData()
            ->export();

        $this->assertTrue($catalogPromotion->tag instanceof Tag);
    }
}
