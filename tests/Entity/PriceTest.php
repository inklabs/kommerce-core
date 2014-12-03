<?php
namespace inklabs\kommerce\Entity;

class PriceTest extends \PHPUnit_Framework_TestCase
{
    public function testCreate()
    {
        $price = new Price;
        $price->origUnitPrice = 2500;
        $price->unitPrice = 1750;
        $price->origQuantityPrice = 2500;
        $price->quantityPrice = 1750;
        $price->addCatalogPromotion(new CatalogPromotion);
        $price->setProductQuantityDiscount(new ProductQuantityDiscount);

        $this->assertInstanceOf('inklabs\kommerce\Entity\CatalogPromotion', $price->getCatalogPromotions()[0]);
        $this->assertInstanceOf(
            'inklabs\kommerce\Entity\ProductQuantityDiscount',
            $price->getProductQuantityDiscount()
        );
    }
}
