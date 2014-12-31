<?php
namespace inklabs\kommerce\Service;

use inklabs\kommerce\Entity as Entity;

class PricingCalculatorTest extends \PHPUnit_Framework_TestCase
{
    /* @var PricingCalculator */
    protected $pricingCalculator;

    /* @var Pricing */
    protected $pricing;

    public function setUp()
    {
        $this->pricing = new Pricing;
        $this->pricingCalculator = new PricingCalculator($this->pricing);
    }

    public function testGetPrice()
    {
        $product = new Entity\Product;
        $product->setUnitPrice(1500);

        $expectedPrice = new Entity\Price;
        $expectedPrice->origUnitPrice = 1500;
        $expectedPrice->unitPrice = 1500;
        $expectedPrice->origQuantityPrice = 1500;
        $expectedPrice->quantityPrice = 1500;
        $this->assertEquals($expectedPrice, $this->pricingCalculator->getPrice($product, 1));

        $expectedPrice = new Entity\Price;
        $expectedPrice->origUnitPrice = 1500;
        $expectedPrice->unitPrice = 1500;
        $expectedPrice->origQuantityPrice = 3000;
        $expectedPrice->quantityPrice = 3000;
        $this->assertEquals($expectedPrice, $this->pricingCalculator->getPrice($product, 2));

        $expectedPrice = new Entity\Price;
        $expectedPrice->origUnitPrice = 1500;
        $expectedPrice->unitPrice = 1500;
        $expectedPrice->origQuantityPrice = 15000;
        $expectedPrice->quantityPrice = 15000;
        $this->assertEquals($expectedPrice, $this->pricingCalculator->getPrice($product, 10));
    }

    public function testGetPriceWithCatalogPromotion()
    {
        $catalogPromotion = new Entity\CatalogPromotion;
        $catalogPromotion->setName('20% Off');
        $catalogPromotion->setType(Entity\Promotion::TYPE_PERCENT);
        $catalogPromotion->setValue(20);

        $this->pricing->setCatalogPromotions([$catalogPromotion]);

        $product = new Entity\Product;
        $product->setUnitPrice(1500);

        $expectedPrice = new Entity\Price;
        $expectedPrice->unitPrice = 1200;
        $expectedPrice->origUnitPrice = 1500;
        $expectedPrice->addCatalogPromotion($catalogPromotion);
        $expectedPrice->quantityPrice = 1200;
        $expectedPrice->origQuantityPrice = 1500;
        $this->assertEquals($expectedPrice, $this->pricingCalculator->getPrice($product, 1));
    }

    public function testGetPriceWithProductOptions()
    {
        $option = new Entity\Option;
        $option->setName('Size');
        $option->setType('radio');
        $option->setDescription('Navy T-shirt size');

        $productSmall = new Entity\Product;
        $productSmall->setSku('TS-NAVY-SM');
        $productSmall->setName('Navy T-shirt (small)');
        $productSmall->setUnitPrice(900);

        $option->addProduct($productSmall);

        $product = new Entity\Product;
        $product->setUnitPrice(1500);
        $product->addOption($option);
        $product->addProduct($productSmall);

        $expectedPrice = new Entity\Price;
        $expectedPrice->unitPrice = 2400;
        $expectedPrice->origUnitPrice = 2400;
        $expectedPrice->quantityPrice = 2400;
        $expectedPrice->origQuantityPrice = 2400;
        $this->assertEquals($expectedPrice, $this->pricingCalculator->getPrice($product, 1));

        $expectedPrice = new Entity\Price;
        $expectedPrice->unitPrice = 2400;
        $expectedPrice->origUnitPrice = 2400;
        $expectedPrice->quantityPrice = 4800;
        $expectedPrice->origQuantityPrice = 4800;
        $this->assertEquals($expectedPrice, $this->pricingCalculator->getPrice($product, 2));

        $expectedPrice = new Entity\Price;
        $expectedPrice->unitPrice = 2400;
        $expectedPrice->origUnitPrice = 2400;
        $expectedPrice->quantityPrice = 24000;
        $expectedPrice->origQuantityPrice = 24000;
        $this->assertEquals($expectedPrice, $this->pricingCalculator->getPrice($product, 10));
    }

    public function testGetPriceWithProductQuantityDiscountPercent()
    {
        $productQuantityDiscount6 = new Entity\ProductQuantityDiscount;
        $productQuantityDiscount6->setType(Entity\Promotion::TYPE_PERCENT);
        $productQuantityDiscount6->setQuantity(6);
        $productQuantityDiscount6->setValue(5);

        $productQuantityDiscount12 = new Entity\ProductQuantityDiscount;
        $productQuantityDiscount12->setType(Entity\Promotion::TYPE_PERCENT);
        $productQuantityDiscount12->setQuantity(12);
        $productQuantityDiscount12->setValue(30);

        $productQuantityDiscount24 = new Entity\ProductQuantityDiscount;
        $productQuantityDiscount24->setType(Entity\Promotion::TYPE_PERCENT);
        $productQuantityDiscount24->setQuantity(24);
        $productQuantityDiscount24->setValue(35);

        $product = new Entity\Product;
        $product->setUnitPrice(500);
        $product->addProductQuantityDiscount($productQuantityDiscount24);
        $product->addProductQuantityDiscount($productQuantityDiscount12);
        $product->addProductQuantityDiscount($productQuantityDiscount6);

        $productQuantityDiscounts = $product->getProductQuantityDiscounts();
        $this->pricing->setProductQuantityDiscounts($productQuantityDiscounts);

        $expectedPrice = new Entity\Price;
        $expectedPrice->unitPrice = 500;
        $expectedPrice->origUnitPrice = 500;
        $expectedPrice->quantityPrice = 500;
        $expectedPrice->origQuantityPrice = 500;
        $this->assertEquals($expectedPrice, $this->pricingCalculator->getPrice($product, 1));

        $expectedPrice = new Entity\Price;
        $expectedPrice->unitPrice = 475;
        $expectedPrice->origUnitPrice = 500;
        $expectedPrice->quantityPrice = 2850;
        $expectedPrice->origQuantityPrice = 3000;
        $expectedPrice->setProductQuantityDiscount($productQuantityDiscount6);
        $this->assertEquals($expectedPrice, $this->pricingCalculator->getPrice($product, 6));

        $expectedPrice = new Entity\Price;
        $expectedPrice->unitPrice = 350;
        $expectedPrice->origUnitPrice = 500;
        $expectedPrice->quantityPrice = 4200;
        $expectedPrice->origQuantityPrice = 6000;
        $expectedPrice->setProductQuantityDiscount($productQuantityDiscount12);
        $this->assertEquals($expectedPrice, $this->pricingCalculator->getPrice($product, 12));

        $expectedPrice = new Entity\Price;
        $expectedPrice->unitPrice = 325;
        $expectedPrice->origUnitPrice = 500;
        $expectedPrice->quantityPrice = 7800;
        $expectedPrice->origQuantityPrice = 12000;
        $expectedPrice->setProductQuantityDiscount($productQuantityDiscount24);
        $this->assertEquals($expectedPrice, $this->pricingCalculator->getPrice($product, 24));
    }
}
