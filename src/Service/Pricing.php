<?php
namespace inklabs\kommerce\Service;

use inklabs\kommerce\Entity as Entity;
use Doctrine as Doctrine;

class Pricing
{
    /* @var \DateTime */
    protected $date;

    /* @var Entity\CatalogPromotion[] */
    protected $catalogPromotions = [];

    /* @var Entity\ProductQuantityDiscount[] */
    protected $productQuantityDiscounts = [];

    public function __construct(\DateTime $date = null)
    {
        if ($date === null) {
            $this->date = new \DateTime('now', new \DateTimeZone('UTC'));
        } else {
            $this->date = $date;
        }
    }

    /**
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    public function setCatalogPromotions(array $catalogPromotions)
    {
        $this->catalogPromotions = [];
        foreach ($catalogPromotions as $catalogPromotion) {
            $this->addCatalogPromotion($catalogPromotion);
        }
    }

    public function loadCatalogPromotions(Doctrine\ORM\EntityManager $entityManager)
    {
        $catalogPromotionService = new CatalogPromotion($entityManager);
        $this->setCatalogPromotions($catalogPromotionService->findAll());
    }

    private function addCatalogPromotion(Entity\CatalogPromotion $catalogPromotion)
    {
        $this->catalogPromotions[] = $catalogPromotion;
    }

    /**
     * @return Entity\CatalogPromotion[]
     */
    public function getCatalogPromotions()
    {
        return $this->catalogPromotions;
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

    /**
     * @return Entity\ProductQuantityDiscount[]
     */
    public function getProductQuantityDiscounts()
    {
        return $this->productQuantityDiscounts;
    }

    /**
     * @return Entity\Price
     */
    public function getPrice(Entity\Product $product, $quantity)
    {
        $pricingCalculator = new PricingCalculator($this);
        return $pricingCalculator->getPrice($product, $quantity);
    }
}
