<?php
namespace inklabs\kommerce\Entity;

use Symfony\Component\Validator\Validation;

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
        $price->addProductQuantityDiscount(new ProductQuantityDiscount);

        $validator = Validation::createValidatorBuilder()
            ->addMethodMapping('loadValidatorMetadata')
            ->getValidator();

        $this->assertEmpty($validator->validate($price));
        $this->assertTrue($price->getCatalogPromotions()[0] instanceof CatalogPromotion);
        $this->assertTrue($price->getProductQuantityDiscounts()[0] instanceof ProductQuantityDiscount);
        $this->assertTrue($price->getView() instanceof View\Price);
    }

    public function testAdd()
    {
        $one = new Price;
        $one->unitPrice         = 1;
        $one->origUnitPrice     = 1;
        $one->quantityPrice     = 1;
        $one->origQuantityPrice = 1;

        $two = new Price;
        $two->unitPrice         = 2;
        $two->origUnitPrice     = 2;
        $two->quantityPrice     = 2;
        $two->origQuantityPrice = 2;

        $three = new Price;
        $three->unitPrice         = 3;
        $three->origUnitPrice     = 3;
        $three->quantityPrice     = 3;
        $three->origQuantityPrice = 3;

        $this->assertEquals($three, Price::add($one, $two));
    }
}
