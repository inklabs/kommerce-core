<?php
namespace inklabs\kommerce\EntityDTO\Builder;

use inklabs\kommerce\Entity\Price;
use inklabs\kommerce\EntityDTO\PriceDTO;

class PriceDTOBuilder
{
    /** @var Price */
    protected $price;

    /** @var PriceDTO */
    protected $priceDTO;

    public function __construct(Price $price)
    {
        $this->price = $price;

        $this->priceDTO = new PriceDTO;
        $this->priceDTO->origUnitPrice     = $this->price->origUnitPrice;
        $this->priceDTO->unitPrice         = $this->price->unitPrice;
        $this->priceDTO->origQuantityPrice = $this->price->origQuantityPrice;
        $this->priceDTO->quantityPrice     = $this->price->quantityPrice;
    }

    public function withCatalogPromotions()
    {
        foreach ($this->price->getCatalogPromotions() as $catalogPromotion) {
            $this->priceDTO->catalogPromotions[] = $catalogPromotion->getDTOBuilder()
                ->build();
        }

        return $this;
    }

    public function withProductQuantityDiscounts()
    {
        foreach ($this->price->getProductQuantityDiscounts() as $productQuantityDiscount) {
            $this->priceDTO->productQuantityDiscounts[] = $productQuantityDiscount->getDTOBuilder()
                ->build();
        }

        return $this;
    }

    public function withAllData()
    {
        return $this
            ->withCatalogPromotions()
            ->withProductQuantityDiscounts();
    }

    public function build()
    {
        return $this->priceDTO;
    }
}
