<?php
namespace inklabs\kommerce\Service;

use inklabs\kommerce\Entity;
use inklabs\kommerce\tests\Helper;
use inklabs\kommerce\tests\EntityRepository\FakeCatalogPromotion;
use inklabs\kommerce\tests\EntityRepository\FakeCartPriceRule;

class PricingTest extends Helper\DoctrineTestCase
{
    /** @var Pricing */
    protected $pricingService;

    public function setUp()
    {
        $this->pricingService = new Pricing;
    }

    public function testCreate()
    {
        $this->pricingService = new Pricing(new \DateTime);
        $productQuantityDiscount = new Entity\ProductQuantityDiscount;
        $productQuantityDiscount->setType(Entity\Promotion::TYPE_FIXED);
        $this->pricingService->setProductQuantityDiscounts([$productQuantityDiscount]);

        $catalogPromotion = new Entity\CatalogPromotion;
        $catalogPromotion->setType(Entity\Promotion::TYPE_FIXED);
        $this->pricingService->setCatalogPromotions([$catalogPromotion]);

        $this->assertTrue($this->pricingService->getPrice(new Entity\Product, 1) instanceof Entity\Price);
        $this->assertTrue($this->pricingService->getDate() instanceof \DateTime);
        $this->assertTrue(
            $this->pricingService->getProductQuantityDiscounts()[0] instanceof Entity\ProductQuantityDiscount
        );
        $this->assertTrue($this->pricingService->getCatalogPromotions()[0] instanceof Entity\CatalogPromotion);
    }

    public function testCreateWithEmptyDate()
    {
        $price = $this->pricingService->getPrice(new Entity\Product, 1);
        $this->assertTrue($price instanceof Entity\Price);
    }

    public function testLoadCatalogPromotions()
    {
        $this->pricingService->loadCatalogPromotions(new FakeCatalogPromotion);
        $catalogPromotions = $this->pricingService->getCatalogPromotions();
        $this->assertTrue($catalogPromotions[0] instanceof Entity\CatalogPromotion);
    }

    public function testLoadCartPriceRules()
    {
        $this->pricingService->loadCartPriceRules(new FakeCartPriceRule);
        $cartPriceRules = $this->pricingService->getCartPriceRules();
        $this->assertTrue($cartPriceRules[0] instanceof Entity\CartPriceRule);
    }
}
