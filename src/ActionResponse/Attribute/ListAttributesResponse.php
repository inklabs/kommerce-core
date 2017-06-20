<?php
namespace inklabs\kommerce\ActionResponse\Attribute;

use inklabs\kommerce\EntityDTO\Builder\AttributeDTOBuilder;
use inklabs\kommerce\EntityDTO\Builder\PaginationDTOBuilder;
use inklabs\kommerce\EntityDTO\AttributeDTO;
use inklabs\kommerce\EntityDTO\PaginationDTO;
use inklabs\kommerce\Lib\Query\ResponseInterface;

final class ListAttributesResponse implements ResponseInterface
{
    /** @var AttributeDTOBuilder[] */
    protected $attributeDTOBuilders = [];

    /** @var PaginationDTOBuilder */
    protected $paginationDTOBuilder;

    public function addAttributeDTOBuilder(AttributeDTOBuilder $attributeDTOBuilder): void
    {
        $this->attributeDTOBuilders[] = $attributeDTOBuilder;
    }

    public function setPaginationDTOBuilder(PaginationDTOBuilder $paginationDTOBuilder): void
    {
        $this->paginationDTOBuilder = $paginationDTOBuilder;
    }

    /**
     * @return AttributeDTO[]
     */
    public function getAttributeDTOs(): array
    {
        $attributeDTOs = [];
        foreach ($this->attributeDTOBuilders as $attributeDTOBuilder) {
            $attributeDTOs[] = $attributeDTOBuilder->build();
        }
        return $attributeDTOs;
    }

    public function getPaginationDTO(): PaginationDTO
    {
        return $this->paginationDTOBuilder->build();
    }
}
