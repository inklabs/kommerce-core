<?php
namespace inklabs\kommerce\Lib;

use DateTime;
use inklabs\kommerce\Entity\CartPriceRule;
use inklabs\kommerce\Entity\CatalogPromotion;
use inklabs\kommerce\Entity\Price;
use inklabs\kommerce\Entity\Product;
use inklabs\kommerce\Entity\ProductQuantityDiscount;
use inklabs\kommerce\tests\Helper\EntityRepository\FakeCartPriceRuleRepository;
use inklabs\kommerce\tests\Helper\TestCase\EntityRepositoryTestCase;

class PricingTest extends EntityRepositoryTestCase
{
    /** @var Pricing */
    protected $pricing;

    public function setUp()
    {
        parent::setUp();
        $this->pricing = $this->dummyData->getPricing();
    }

    public function testCreate()
    {
        $productQuantityDiscount = $this->dummyData->getProductQuantityDiscount();
        $catalogPromotion = $this->dummyData->getCatalogPromotion();

        $this->pricing->setProductQuantityDiscounts([$productQuantityDiscount]);
        $this->pricing->setCatalogPromotions([$catalogPromotion]);

        $this->assertTrue($this->pricing->getPrice(new Product, 1) instanceof Price);
        $this->assertTrue($this->pricing->getDate() instanceof DateTime);
        $this->assertTrue(
            $this->pricing->getProductQuantityDiscounts()[0] instanceof ProductQuantityDiscount
        );
        $this->assertTrue($this->pricing->getCatalogPromotions()[0] instanceof CatalogPromotion);
    }

    public function testCreateWithEmptyDate()
    {
        $price = $this->pricing->getPrice(new Product, 1);
        $this->assertTrue($price instanceof Price);
    }

    public function testLoadCatalogPromotions()
    {
        $originalCatalogPromotion = $this->dummyData->getCatalogPromotion();
        $catalogPromotionRepository = $this->mockRepository->getCatalogPromotionRepository();
        $catalogPromotionRepository->shouldreceive('findAll')
            ->andReturn([$originalCatalogPromotion])
            ->once();

        $this->pricing->loadCatalogPromotions($catalogPromotionRepository);

        $catalogPromotions = $this->pricing->getCatalogPromotions();
        $this->assertEntitiesEqual($originalCatalogPromotion, $catalogPromotions[0]);
    }

    public function testLoadCartPriceRules()
    {
        $cartPriceRule1 = $this->dummyData->getCartPriceRule();
        $cartPriceRuleRepository = $this->mockRepository->getCartPriceRuleRepository();
        $cartPriceRuleRepository->shouldReceive('findAll')
            ->andReturn([$cartPriceRule1])
            ->once();

        $this->pricing->loadCartPriceRules($cartPriceRuleRepository);
        $cartPriceRules = $this->pricing->getCartPriceRules();

        $this->assertEntitiesEqual($cartPriceRule1, $cartPriceRules[0]);
    }
}
