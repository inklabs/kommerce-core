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

        $reflection = new \ReflectionClass('inklabs\kommerce\Entity\View\Price');
        $this->expected = $reflection->newInstanceWithoutConstructor();
        $reflectionProperty = $reflection->getProperty('price');
        $reflectionProperty->setAccessible(true);
        $reflectionProperty->setValue($this->expected, $this->price);
    }

    public function testGetView()
    {
        $this->expected->orig_unit_price     = $this->price->orig_unit_price;
        $this->expected->unit_price          = $this->price->unit_price;
        $this->expected->orig_quantity_price = $this->price->orig_quantity_price;
        $this->expected->quantity_price      = $this->price->quantity_price;

        $this->expected = $this->expected->export();
        $this->assertEquals($this->expected, $this->price->getView()->export());
    }

    public function testGetViewWithCatalogPromotions()
    {
        $this->catalogPromotion = new CatalogPromotion;
        $this->catalogPromotion->setName('30% Off');
        $this->catalogPromotion->setDiscountType('percent');
        $this->catalogPromotion->setValue(30);
        $this->catalogPromotion->setStart(new \DateTime('2014-01-01', new \DateTimeZone('UTC')));
        $this->catalogPromotion->setEnd(new \DateTime('2014-12-31', new \DateTimeZone('UTC')));

        $this->price->addCatalogPromotion($this->catalogPromotion);

        $this->expected->orig_unit_price     = $this->price->orig_unit_price;
        $this->expected->unit_price          = $this->price->unit_price;
        $this->expected->orig_quantity_price = $this->price->orig_quantity_price;
        $this->expected->quantity_price      = $this->price->quantity_price;
        $this->expected->productQuantityDiscounts   = [];
        $this->expected->catalogPromotions   = [
            $this->catalogPromotion
                ->getView()
                ->withAllData()
                ->export()
        ];

        $this->expected = $this->expected->export();
        $this->assertEquals($this->expected, $this->price->getView()->withCatalogPromotions()->export());
        
    }

    public function testGetViewWithQuantityDiscounts()
    {
        $productQuantityDiscount = new ProductQuantityDiscount;
        $productQuantityDiscount->setName('6x for $5 ea.');
        $productQuantityDiscount->setCustomerGroup(null);
        $productQuantityDiscount->setDiscountType('exact');
        $productQuantityDiscount->setQuantity(6);
        $productQuantityDiscount->setValue(500);
        $productQuantityDiscount->setStart(new \DateTime('2014-01-01', new \DateTimeZone('UTC')));
        $productQuantityDiscount->setEnd(new \DateTime('2014-12-31', new \DateTimeZone('UTC')));

        $this->price->addProductQuantityDiscount($productQuantityDiscount);

        $this->expected->orig_unit_price     = $this->price->orig_unit_price;
        $this->expected->unit_price          = $this->price->unit_price;
        $this->expected->orig_quantity_price = $this->price->orig_quantity_price;
        $this->expected->quantity_price      = $this->price->quantity_price;
        $this->expected->productQuantityDiscounts  = [
            $productQuantityDiscount
                ->getView()
                ->withAllData()
                ->export()
        ];
        $this->expected->catalogPromotions   = [];

        $this->expected = $this->expected->export();
        $result = $this->price
            ->getView()
            ->withProductQuantityDiscounts()
            ->export();

        $this->assertEquals($this->expected, $result);
    }

    public function testGetViewWithAllData()
    {
        $this->expected->orig_unit_price     = $this->price->orig_unit_price;
        $this->expected->unit_price          = $this->price->unit_price;
        $this->expected->orig_quantity_price = $this->price->orig_quantity_price;
        $this->expected->quantity_price      = $this->price->quantity_price;
        $this->expected->productQuantityDiscounts   = [];
        $this->expected->catalogPromotions   = [];

        $this->expected = $this->expected->export();
        $this->assertEquals($this->expected, $this->price->getView()->withAllData()->export());
    }
}
