<?php
namespace inklabs\kommerce\ActionResponse\Product;

use inklabs\kommerce\EntityDTO\Builder\PaginationDTOBuilder;
use inklabs\kommerce\EntityDTO\Builder\ProductDTOBuilder;
use inklabs\kommerce\EntityDTO\PaginationDTO;
use inklabs\kommerce\EntityDTO\ProductDTO;
use inklabs\kommerce\Lib\PricingInterface;
use inklabs\kommerce\Lib\Query\ResponseInterface;

final class GetProductsByTagResponse implements ResponseInterface
{
    /** @var ProductDTO[] */
    protected $productDTOs = [];

    /** @var PaginationDTO */
    protected $paginationDTO;

    /** @var PricingInterface */
    private $pricing;

    public function __construct(PricingInterface $pricing)
    {
        $this->pricing = $pricing;
    }

    public function addProductDTOBuilder(ProductDTOBuilder $productDTOBuilder): void
    {
        $this->productDTOs[] = $productDTOBuilder
            ->withPrice($this->pricing)
            ->build();
    }

    public function setPaginationDTOBuilder(PaginationDTOBuilder $paginationDTOBuilder): void
    {
        $this->paginationDTO = $paginationDTOBuilder
            ->build();
    }

    /**
     * @return ProductDTO[]
     */
    public function getProductDTOs(): array
    {
        return $this->productDTOs;
    }

    public function getPaginationDTO(): PaginationDTO
    {
        return $this->paginationDTO;
    }
}
