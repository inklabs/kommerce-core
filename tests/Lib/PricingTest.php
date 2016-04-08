<?php
namespace inklabs\kommerce\Lib;

use DateTime;
use inklabs\kommerce\Entity\CartPriceRule;
use inklabs\kommerce\Entity\CatalogPromotion;
use inklabs\kommerce\Entity\Price;
use inklabs\kommerce\Entity\Product;
use inklabs\kommerce\Entity\ProductQuantityDiscount;
use inklabs\kommerce\Entity\PromotionType;
use inklabs\kommerce\tests\Helper;
use inklabs\kommerce\tests\Helper\EntityRepository\FakeCatalogPromotionRepository;
use inklabs\kommerce\tests\Helper\EntityRepository\FakeCartPriceRuleRepository;

class PricingTest extends Helper\DoctrineTestCase
{
    /** @var Pricing */
    protected $pricing;

    public function setUp()
    {
        $this->pricing = new Pricing;
    }

    public function testCreate()
    {
        $this->pricing = new Pricing(new DateTime);
        $productQuantityDiscount = new ProductQuantityDiscount;
        $productQuantityDiscount->setType(PromotionType::fixed());
        $this->pricing->setProductQuantityDiscounts([$productQuantityDiscount]);

        $catalogPromotion = new CatalogPromotion;
        $catalogPromotion->setType(PromotionType::fixed());
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
        $this->pricing->loadCatalogPromotions(new FakeCatalogPromotionRepository);
        $catalogPromotions = $this->pricing->getCatalogPromotions();
        $this->assertTrue($catalogPromotions[0] instanceof CatalogPromotion);
    }

    public function testLoadCartPriceRules()
    {
        $this->pricing->loadCartPriceRules(new FakeCartPriceRuleRepository);
        $cartPriceRules = $this->pricing->getCartPriceRules();
        $this->assertTrue($cartPriceRules[0] instanceof CartPriceRule);
    }
}
