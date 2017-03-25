<?php
namespace inklabs\kommerce\ActionResponse\Warehouse;

use Generator;
use inklabs\kommerce\DTO\ProductStockDTO;
use inklabs\kommerce\Entity\Pagination;
use inklabs\kommerce\Entity\ProductStock;
use inklabs\kommerce\EntityDTO\Builder\DTOBuilderFactoryInterface;
use inklabs\kommerce\Lib\Query\ResponseInterface;

final class ListProductStockForInventoryLocationResponse implements ResponseInterface
{
    /** @var DTOBuilderFactoryInterface */
    private $dtoBuilderFactory;

    /** @var Pagination */
    private $pagination;

    /** @var ProductStock */
    private $productStockList;

    public function __construct(
        DTOBuilderFactoryInterface $dtoBuilderFactory,
        Pagination $pagination,
        Generator $productStockList
    ) {
        $this->dtoBuilderFactory = $dtoBuilderFactory;
        $this->pagination = $pagination;
        $this->productStockList = $productStockList;
    }

    public function getPaginationDTO()
    {
        return $this->dtoBuilderFactory->getPaginationDTOBuilder($this->pagination)
            ->build();
    }

    /**
     * @return \Generator|ProductStockDTO[]
     */
    public function getProductStockDTOs()
    {
        foreach ($this->productStockList as $productStock) {
            $productDTO = $this->dtoBuilderFactory->getProductDTOBuilder($productStock->getProduct())
                ->build();

            yield new ProductStockDTO($productDTO, $productStock->getQuantity());
        }
    }
}
