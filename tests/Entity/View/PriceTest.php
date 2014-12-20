<?php
namespace inklabs\kommerce\Entity\View;

use inklabs\kommerce\Entity as Entity;

class PriceTest extends \PHPUnit_Framework_TestCase
{
    public function testCreate()
    {
        $entityPrice = new Entity\Price;
        $entityPrice->addCatalogPromotion(new Entity\CatalogPromotion);
        $entityPrice->setProductQuantityDiscount(new Entity\ProductQuantityDiscount);

        $price = $entityPrice->getView()
            ->withAllData()
            ->export();

        $this->assertTrue($price->catalogPromotions[0] instanceof CatalogPromotion);
        $this->assertTrue($price->productQuantityDiscount instanceof ProductQuantityDiscount);
    }
}
