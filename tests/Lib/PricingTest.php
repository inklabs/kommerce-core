<?php
namespace inklabs\kommerce\Lib;

use inklabs\kommerce\Entity;
use inklabs\kommerce\tests\Helper;
use inklabs\kommerce\tests\Helper\EntityRepository\FakeRepositoryCatalogPromotion;
use inklabs\kommerce\tests\Helper\EntityRepository\FakeRepositoryCartPriceRule;

class PricingInterfaceTest extends Helper\DoctrineTestCase
{
    /** @var Pricing */
    protected $pricing;

    public function setUp()
    {
        $this->pricing = new Pricing;
    }

    public function testCreate()
    {
        $this->pricing = new Pricing(new \DateTime);
        $productQuantityDiscount = new Entity\ProductQuantityDiscount;
        $productQuantityDiscount->setType(Entity\Promotion::TYPE_FIXED);
        $this->pricing->setProductQuantityDiscounts([$productQuantityDiscount]);

        $catalogPromotion = new Entity\CatalogPromotion;
        $catalogPromotion->setType(Entity\Promotion::TYPE_FIXED);
        $this->pricing->setCatalogPromotions([$catalogPromotion]);

        $this->assertTrue($this->pricing->getPrice(new Entity\Product, 1) instanceof Entity\Price);
        $this->assertTrue($this->pricing->getDate() instanceof \DateTime);
        $this->assertTrue(
            $this->pricing->getProductQuantityDiscounts()[0] instanceof Entity\ProductQuantityDiscount
        );
        $this->assertTrue($this->pricing->getCatalogPromotions()[0] instanceof Entity\CatalogPromotion);
    }

    public function testCreateWithEmptyDate()
    {
        $price = $this->pricing->getPrice(new Entity\Product, 1);
        $this->assertTrue($price instanceof Entity\Price);
    }

    public function testLoadCatalogPromotions()
    {
        $this->pricing->loadCatalogPromotions(new FakeRepositoryCatalogPromotion);
        $catalogPromotions = $this->pricing->getCatalogPromotions();
        $this->assertTrue($catalogPromotions[0] instanceof Entity\CatalogPromotion);
    }

    public function testLoadCartPriceRules()
    {
        $this->pricing->loadCartPriceRules(new FakeRepositoryCartPriceRule);
        $cartPriceRules = $this->pricing->getCartPriceRules();
        $this->assertTrue($cartPriceRules[0] instanceof Entity\CartPriceRule);
    }
}
