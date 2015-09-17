<?php
namespace inklabs\kommerce\Lib;

use inklabs\kommerce\Entity;
use inklabs\kommerce\EntityRepository\CartPriceRuleRepositoryInterface;
use inklabs\kommerce\EntityRepository\CatalogPromotionRepositoryInterface;

class Pricing implements PricingInterface
{
    /** @var \DateTime */
    protected $date;

    /** @var Entity\CatalogPromotion[] */
    protected $catalogPromotions = [];

    /** @var Entity\ProductQuantityDiscount[] */
    protected $productQuantityDiscounts = [];

    /** @var Entity\CartPriceRule[] */
    protected $cartPriceRules = [];

    public function __construct(\DateTime $date = null)
    {
        if ($date === null) {
            $this->date = new \DateTime('now', new \DateTimeZone('UTC'));
        } else {
            $this->date = $date;
        }
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

    private function addCatalogPromotion(Entity\CatalogPromotion $catalogPromotion)
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

    private function addCartPriceRule(Entity\CartPriceRule $cartPriceRule)
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

    private function addProductQuantityDiscount(Entity\ProductQuantityDiscount $productQuantityDiscount)
    {
        $this->productQuantityDiscounts[] = $productQuantityDiscount;
    }

    private function sortProductQuantityDiscountsByQuantityDescending()
    {
        usort(
            $this->productQuantityDiscounts,
            create_function('$a, $b', 'return ($a->getQuantity() < $b->getQuantity());')
        );
    }

    public function getProductQuantityDiscounts()
    {
        return $this->productQuantityDiscounts;
    }

    /**
     * @param Entity\Product $product
     * @param int $quantity
     * @return Entity\Price
     */
    public function getPrice(Entity\Product $product, $quantity)
    {
        $pricingCalculator = new PricingCalculator($this);
        return $pricingCalculator->getPrice($product, $quantity);
    }
}
