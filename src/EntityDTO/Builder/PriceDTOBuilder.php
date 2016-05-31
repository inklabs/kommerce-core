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

    /** @var DTOBuilderFactoryInterface */
    private $dtoBuilderFactory;

    public function __construct(Price $price, DTOBuilderFactoryInterface $dtoBuilderFactory)
    {
        $this->price = $price;
        $this->dtoBuilderFactory = $dtoBuilderFactory;

        $this->initializePriceDTO();
        $this->priceDTO->origUnitPrice     = $this->price->origUnitPrice;
        $this->priceDTO->unitPrice         = $this->price->unitPrice;
        $this->priceDTO->origQuantityPrice = $this->price->origQuantityPrice;
        $this->priceDTO->quantityPrice     = $this->price->quantityPrice;
    }

    protected function initializePriceDTO()
    {
        $this->priceDTO = new PriceDTO;
    }

    public function withCatalogPromotions()
    {
        $catalogPromotions = $this->price->getCatalogPromotions();

        if ($catalogPromotions !== null) {
            foreach ($catalogPromotions as $catalogPromotion) {
                $this->priceDTO->catalogPromotions[] = $this->dtoBuilderFactory
                    ->getCatalogPromotionDTOBuilder($catalogPromotion)
                    ->build();
            }
        }

        return $this;
    }

    public function withProductQuantityDiscounts()
    {
        $productQuantityDiscounts = $this->price->getProductQuantityDiscounts();

        if ($productQuantityDiscounts !== null) {
            foreach ($productQuantityDiscounts as $productQuantityDiscount) {
                $this->priceDTO->productQuantityDiscounts[] = $this->dtoBuilderFactory
                    ->getProductQuantityDiscountDTOBuilder($productQuantityDiscount)
                    ->build();
            }
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
