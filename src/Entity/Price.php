<?php
namespace inklabs\kommerce\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;

class Price implements ValidationInterface
{
    /** @var int */
    public $origUnitPrice;

    /** @var int */
    public $unitPrice;

    /** @var int */
    public $origQuantityPrice;

    /** @var int */
    public $quantityPrice;

    /** @var CatalogPromotion[]|ArrayCollection|null */
    protected $catalogPromotions;

    /** @var ProductQuantityDiscount[]|ArrayCollection|null */
    protected $productQuantityDiscounts;

    public function __construct()
    {
        $this->catalogPromotions = new ArrayCollection();
        $this->productQuantityDiscounts = new ArrayCollection();
    }

    public static function loadValidatorMetadata(ClassMetadata $metadata): void
    {
        $metadata->addPropertyConstraint('origUnitPrice', new Assert\NotNull);
        $metadata->addPropertyConstraint('origUnitPrice', new Assert\Range([
            'min' => -2147483648,
            'max' => 2147483647,
        ]));
        $metadata->addPropertyConstraint('unitPrice', new Assert\NotNull);
        $metadata->addPropertyConstraint('unitPrice', new Assert\Range([
            'min' => -2147483648,
            'max' => 2147483647,
        ]));
        $metadata->addPropertyConstraint('origQuantityPrice', new Assert\NotNull);
        $metadata->addPropertyConstraint('origQuantityPrice', new Assert\Range([
            'min' => -2147483648,
            'max' => 2147483647,
        ]));
        $metadata->addPropertyConstraint('quantityPrice', new Assert\NotNull);
        $metadata->addPropertyConstraint('quantityPrice', new Assert\Range([
            'min' => -2147483648,
            'max' => 2147483647,
        ]));
    }

    public function addCatalogPromotion(CatalogPromotion $catalogPromotion)
    {
        if (! $this->catalogPromotions->contains($catalogPromotion)) {
            $this->catalogPromotions->add($catalogPromotion);
        }
    }

    /**
     * @return ArrayCollection|CatalogPromotion[]|null
     */
    public function getCatalogPromotions()
    {
        return $this->catalogPromotions;
    }

    public function addProductQuantityDiscount(ProductQuantityDiscount $productQuantityDiscount)
    {
        if (! $this->productQuantityDiscounts->contains($productQuantityDiscount)) {
            $this->productQuantityDiscounts->add($productQuantityDiscount);
        }
    }

    /**
     * @return ArrayCollection|ProductQuantityDiscount[]|null
     */
    public function getProductQuantityDiscounts()
    {
        return $this->productQuantityDiscounts;
    }

    public static function add(Price $a, Price $b): Price
    {
        $price = clone $a;
        $price->unitPrice         += $b->unitPrice;
        $price->origUnitPrice     += $b->origUnitPrice;
        $price->quantityPrice     += $b->quantityPrice;
        $price->origQuantityPrice += $b->origQuantityPrice;

        foreach ($b->getCatalogPromotions() as $catalogPromotion) {
            $price->addCatalogPromotion($catalogPromotion);
        }

        foreach ($b->getProductQuantityDiscounts() as $productQuantityDiscount) {
            $price->addProductQuantityDiscount($productQuantityDiscount);
        }

        return $price;
    }
}
