<?php
namespace inklabs\kommerce\EntityDTO\Builder;

use inklabs\kommerce\Entity\Price;
use inklabs\kommerce\EntityDTO\PriceDTO;

class PriceDTOBuilder implements DTOBuilderInterface
{
    /** @var Price */
    protected $entity;

    /** @var PriceDTO */
    protected $entityDTO;

    /** @var DTOBuilderFactoryInterface */
    protected $dtoBuilderFactory;

    public function __construct(Price $price, DTOBuilderFactoryInterface $dtoBuilderFactory)
    {
        $this->entity = $price;
        $this->dtoBuilderFactory = $dtoBuilderFactory;

        $this->initializePriceDTO();
        $this->entityDTO->origUnitPrice     = $this->entity->origUnitPrice;
        $this->entityDTO->unitPrice         = $this->entity->unitPrice;
        $this->entityDTO->origQuantityPrice = $this->entity->origQuantityPrice;
        $this->entityDTO->quantityPrice     = $this->entity->quantityPrice;
    }

    protected function initializePriceDTO()
    {
        $this->entityDTO = new PriceDTO;
    }

    public function withCatalogPromotions()
    {
        $catalogPromotions = $this->entity->getCatalogPromotions();

        if ($catalogPromotions !== null) {
            foreach ($catalogPromotions as $catalogPromotion) {
                $this->entityDTO->catalogPromotions[] = $this->dtoBuilderFactory
                    ->getCatalogPromotionDTOBuilder($catalogPromotion)
                    ->build();
            }
        }

        return $this;
    }

    public function withProductQuantityDiscounts()
    {
        $productQuantityDiscounts = $this->entity->getProductQuantityDiscounts();

        if ($productQuantityDiscounts !== null) {
            foreach ($productQuantityDiscounts as $productQuantityDiscount) {
                $this->entityDTO->productQuantityDiscounts[] = $this->dtoBuilderFactory
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

    protected function preBuild()
    {
    }

    public function build()
    {
        $this->preBuild();
        unset($this->entity);
        return $this->entityDTO;
    }
}
