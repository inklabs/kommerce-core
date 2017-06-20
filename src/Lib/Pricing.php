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

    public function getDate(): DateTime
    {
        return $this->date;
    }

    public function getPrice(Product $product, int $quantity): Price
    {
        $pricingCalculator = new PricingCalculator($this);
        return $pricingCalculator->getPrice($product, $quantity);
    }

    public function loadCatalogPromotions(CatalogPromotionRepositoryInterface $catalogPromotionRepository): void
    {
        $this->setCatalogPromotions($catalogPromotionRepository->findAll());
    }

    public function setCatalogPromotions(array $catalogPromotions): void
    {
        $this->catalogPromotions = [];
        foreach ($catalogPromotions as $catalogPromotion) {
            $this->addCatalogPromotion($catalogPromotion);
        }
    }

    private function addCatalogPromotion(CatalogPromotion $catalogPromotion): void
    {
        $this->catalogPromotions[] = $catalogPromotion;
    }

    /**
     * @return CatalogPromotion[]
     */
    public function getCatalogPromotions(): array
    {
        return $this->catalogPromotions;
    }

    public function loadCartPriceRules(CartPriceRuleRepositoryInterface $cartPriceRuleRepository): void
    {
        $this->setCartPriceRules($cartPriceRuleRepository->findAll());
    }

    /**
     * @param CartPriceRule[] $cartPriceRules
     */
    public function setCartPriceRules(array $cartPriceRules): void
    {
        $this->cartPriceRules = [];
        foreach ($cartPriceRules as $cartPriceRule) {
            $this->addCartPriceRule($cartPriceRule);
        }
    }

    private function addCartPriceRule(CartPriceRule $cartPriceRule): void
    {
        $this->cartPriceRules[] = $cartPriceRule;
    }

    /**
     * @return CartPriceRule[]
     */
    public function getCartPriceRules(): array
    {
        return $this->cartPriceRules;
    }

    /**
     * @param ProductQuantityDiscount[] $productQuantityDiscounts
     */
    public function setProductQuantityDiscounts($productQuantityDiscounts): void
    {
        foreach ($productQuantityDiscounts as $productQuantityDiscount) {
            $this->addProductQuantityDiscount($productQuantityDiscount);
        }

        $this->sortProductQuantityDiscountsByQuantityDescending();
    }

    private function addProductQuantityDiscount(ProductQuantityDiscount $productQuantityDiscount): void
    {
        $this->productQuantityDiscounts[] = $productQuantityDiscount;
    }

    private function sortProductQuantityDiscountsByQuantityDescending(): void
    {
        usort(
            $this->productQuantityDiscounts,
            function (ProductQuantityDiscount $a, ProductQuantityDiscount $b) {
                return ($a->getQuantity() < $b->getQuantity());
            }
        );
    }

    /**
     * @return ProductQuantityDiscount[]
     */
    public function getProductQuantityDiscounts(): array
    {
        return $this->productQuantityDiscounts;
    }
}
