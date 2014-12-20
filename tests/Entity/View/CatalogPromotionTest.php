<?php
namespace inklabs\kommerce\Entity\View;

use inklabs\kommerce\Entity as Entity;

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
