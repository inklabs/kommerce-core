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

        $price = Price::factory($entityPrice)
            ->withAllData()
            ->export();

        $this->assertInstanceOf('inklabs\kommerce\Entity\View\CatalogPromotion', $price->catalogPromotions[0]);
        $this->assertInstanceOf(
            'inklabs\kommerce\Entity\View\ProductQuantityDiscount',
            $price->productQuantityDiscount
        );
    }
}
