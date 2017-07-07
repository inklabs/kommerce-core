<?php
namespace inklabs\kommerce\ActionResponse\Attribute;

use inklabs\kommerce\EntityDTO\Builder\PaginationDTOBuilder;
use inklabs\kommerce\EntityDTO\Builder\ProductAttributeDTOBuilder;
use inklabs\kommerce\EntityDTO\PaginationDTO;
use inklabs\kommerce\EntityDTO\ProductAttributeDTO;
use inklabs\kommerce\Lib\PricingInterface;
use inklabs\kommerce\Lib\Query\ResponseInterface;

final class GetProductAttributesByAttributeValueResponse implements ResponseInterface
{
    /** @var ProductAttributeDTOBuilder[] */
    private $productAttributeDTOBuilders = [];

    /** @var PaginationDTOBuilder */
    private $paginationDTOBuilder;

    /** @var PricingInterface */
    private $pricing;

    public function __construct(PricingInterface $pricing)
    {
        $this->pricing = $pricing;
    }

    public function addProductAttributeDTOBuilder(ProductAttributeDTOBuilder $productAttributeDTOBuilder): void
    {
        $this->productAttributeDTOBuilders[] = $productAttributeDTOBuilder;
    }

    public function setPaginationDTOBuilder(PaginationDTOBuilder $paginationDTOBuilder): void
    {
        $this->paginationDTOBuilder = $paginationDTOBuilder;
    }

    /**
     * @return ProductAttributeDTO[]
     */
    public function getProductAttributeDTOs(): array
    {
        $productAttributeDTOs = [];

        foreach ($this->productAttributeDTOBuilders as $productAttributeDTOBuilder) {
            $productAttributeDTOs[] = $productAttributeDTOBuilder
                ->withAllData($this->pricing)
                ->build();
        }

        return $productAttributeDTOs;
    }

    public function getPaginationDTO(): PaginationDTO
    {
        return $this->paginationDTOBuilder->build();
    }
}
