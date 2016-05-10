<?php
namespace inklabs\kommerce\Lib;

use DateTime;
use DateTimeZone;
use inklabs\kommerce\Entity\CartPriceRule;
use inklabs\kommerce\Entity\CatalogPromotion;
use inklabs\kommerce\Entity\Price;
use inklabs\kommerce\Entity\Product;
use inklabs\kommerce\Entity\ProductQuantityDiscount;
use inklabs\kommerce\EntityRepository\CartPriceRuleRepositoryInterface;
use inklabs\kommerce\EntityRepository\CatalogPromotionRepositoryInterface;

class Pricing implements PricingInterface
{
    /** @var DateTime */
    protected $date;

    /** @var CatalogPromotion[] */
    protected $catalogPromotions = [];

    /** @var ProductQuantityDiscount[] */
    protected $productQuantityDiscounts = [];

    /** @var CartPriceRule[] */
    protected $cartPriceRules = [];

    public function __construct()
    {
        $this->date = new DateTime('now', new DateTimeZone('UTC'));
    }

    public function getDate()
    {
        return $this->date;
    }

    public function loadCatalogPromotions(CatalogPromotionRepositoryInterface $catalogPromotionRepository)
    {
        $this->setCatalogPromotions($catalogPromotionRepository->findAll());
    }

    public function setCatalogPromotions(array $catalogPromotions)
    {
        $this->catalogPromotions = [];
        foreach ($catalogPromotions as $catalogPromotion) {
            $this->addCatalogPromotion($catalogPromotion);
        }
    }

    private function addCatalogPromotion(CatalogPromotion $catalogPromotion)
    {
        $this->catalogPromotions[] = $catalogPromotion;
    }

    public function getCatalogPromotions()
    {
        return $this->catalogPromotions;
    }

    public function loadCartPriceRules(CartPriceRuleRepositoryInterface $cartPriceRuleRepository)
    {
        $this->setCartPriceRules($cartPriceRuleRepository->findAll());
    }

    public function setCartPriceRules(array $cartPriceRules)
    {
        $this->cartPriceRules = [];
        foreach ($cartPriceRules as $cartPriceRule) {
            $this->addCartPriceRule($cartPriceRule);
        }
    }

    private function addCartPriceRule(CartPriceRule $cartPriceRule)
    {
        $this->cartPriceRules[] = $cartPriceRule;
    }

    public function getCartPriceRules()
    {
        return $this->cartPriceRules;
    }

    public function setProductQuantityDiscounts($productQuantityDiscounts)
    {
        foreach ($productQuantityDiscounts as $productQuantityDiscount) {
            $this->addProductQuantityDiscount($productQuantityDiscount);
        }

        $this->sortProductQuantityDiscountsByQuantityDescending();
    }

    private function addProductQuantityDiscount(ProductQuantityDiscount $productQuantityDiscount)
    {
        $this->productQuantityDiscounts[] = $productQuantityDiscount;
    }

    private function sortProductQuantityDiscountsByQuantityDescending()
    {
        usort(
            $this->productQuantityDiscounts,
            function (ProductQuantityDiscount $a, ProductQuantityDiscount $b) {
                return ($a->getQuantity() < $b->getQuantity());
            }
        );
    }

    public function getProductQuantityDiscounts()
    {
        return $this->productQuantityDiscounts;
    }

    /**
     * @param Product $product
     * @param int $quantity
     * @return Price
     */
    public function getPrice(Product $product, $quantity)
    {
        $pricingCalculator = new PricingCalculator($this);
        return $pricingCalculator->getPrice($product, $quantity);
    }
}
