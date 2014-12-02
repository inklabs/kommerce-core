<?php
namespace inklabs\kommerce\Service;

use inklabs\kommerce\Entity as Entity;
use Doctrine as Doctrine;

class Pricing
{
    protected $date;

    private $catalogPromotions = [];
    private $productQuantityDiscounts = [];
    private $price;

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

    public function getPrice(Entity\Product $product, $quantity)
    {
        $this->product = $product;
        $this->quantity = $quantity;

        $this->price = new Entity\Price;
        $this->price->origUnitPrice = $this->product->getUnitPrice();
        $this->price->origQuantityPrice = ($this->price->origUnitPrice * $this->quantity);
        $this->price->unitPrice = $this->price->origUnitPrice;

        $this->applyProductQuantityDiscount();
        $this->applyCatalogPromotions();
        $this->calculateQuantityPrice();
        $this->applyProductOptionPrices();

        return $this->price;
    }

    private function applyProductQuantityDiscount()
    {
        foreach ($this->productQuantityDiscounts as $productQuantityDiscount) {
            if ($productQuantityDiscount->isValid($this->date, $this->quantity)) {
                $this->price->unitPrice = $productQuantityDiscount->getUnitPrice($this->price->unitPrice);
                $this->price->setProductQuantityDiscount($productQuantityDiscount);
                break;
            }
        }

        // No prices below zero!
        $this->price->unitPrice = max(0, $this->price->unitPrice);
    }

    private function applyCatalogPromotions()
    {
        foreach ($this->catalogPromotions as $catalogPromotion) {
            if ($catalogPromotion->isValid($this->date, $this->product)) {
                $this->price->unitPrice = $catalogPromotion->getUnitPrice($this->price->unitPrice);
                $this->price->addCatalogPromotion($catalogPromotion);
            }
        }

        // No prices below zero!
        $this->price->unitPrice = max(0, $this->price->unitPrice);
    }

    private function calculateQuantityPrice()
    {
        $this->price->quantityPrice = ($this->price->unitPrice * $this->quantity);
    }

    private function applyProductOptionPrices()
    {
        // TODO: code smell...
        foreach ($this->product->getSelectedOptionProducts() as $optionProduct) {
            $subPricing = new Pricing($this->date);
            $optionProductPrice = $optionProduct->getPrice($subPricing, $this->quantity);

            $this->price->unitPrice          += $optionProductPrice->unitPrice;
            $this->price->origUnitPrice      += $optionProductPrice->origUnitPrice;
            $this->price->origQuantityPrice  += $optionProductPrice->origQuantityPrice;
            $this->price->quantityPrice      += $optionProductPrice->quantityPrice;
        }
    }
}
