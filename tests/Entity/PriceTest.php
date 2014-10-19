<?php
namespace inklabs\kommerce\Entity;

class PriceTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->price = new Price;
        $this->price->orig_unit_price = 2500;
        $this->price->orig_quantity_price = 2500;

        $this->price->unit_price = 1750;
        $this->price->quantity_price = 1750;

        $this->catalogPromotion = new CatalogPromotion;
        $this->catalogPromotion->setName('30% Off');
        $this->catalogPromotion->setDiscountType('percent');
        $this->catalogPromotion->setValue(30);
        $this->catalogPromotion->setStart(new \DateTime('2014-01-01', new \DateTimeZone('UTC')));
        $this->catalogPromotion->setEnd(new \DateTime('2014-12-31', new \DateTimeZone('UTC')));

        $this->price->addCatalogPromotion($this->catalogPromotion);
    }

    public function testGetData()
    {
        $expected = new \stdClass;
        $expected->orig_unit_price     = $this->price->orig_unit_price;
        $expected->unit_price          = $this->price->unit_price;
        $expected->orig_quantity_price = $this->price->orig_quantity_price;
        $expected->quantity_price      = $this->price->quantity_price;

        $this->assertEquals($expected, $this->price->getData());
    }

    public function testGetAllData()
    {
        $expected = new \stdClass;
        $expected->orig_unit_price     = $this->price->orig_unit_price;
        $expected->unit_price          = $this->price->unit_price;
        $expected->orig_quantity_price = $this->price->orig_quantity_price;
        $expected->quantity_price      = $this->price->quantity_price;
        $expected->catalog_promotions  = [$this->catalogPromotion->getAllData()];

        $this->assertEquals($expected, $this->price->getAllData());
    }
}
