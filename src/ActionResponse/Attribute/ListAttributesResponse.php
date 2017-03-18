<?php
namespace inklabs\kommerce\ActionResponse\Attribute;

use inklabs\kommerce\EntityDTO\Builder\AttributeDTOBuilder;
use inklabs\kommerce\EntityDTO\Builder\PaginationDTOBuilder;
use inklabs\kommerce\EntityDTO\AttributeDTO;
use inklabs\kommerce\EntityDTO\PaginationDTO;

class ListAttributesResponse
{
    /** @var AttributeDTOBuilder[] */
    protected $attributeDTOBuilders = [];

    /** @var PaginationDTOBuilder */
    protected $paginationDTOBuilder;

    public function addAttributeDTOBuilder(AttributeDTOBuilder $attributeDTOBuilder)
    {
        $this->attributeDTOBuilders[] = $attributeDTOBuilder;
    }

    public function setPaginationDTOBuilder(PaginationDTOBuilder $paginationDTOBuilder)
    {
        $this->paginationDTOBuilder = $paginationDTOBuilder;
    }

    /**
     * @return AttributeDTO[]
     */
    public function getAttributeDTOs()
    {
        $attributeDTOs = [];
        foreach ($this->attributeDTOBuilders as $attributeDTOBuilder) {
            $attributeDTOs[] = $attributeDTOBuilder->build();
        }
        return $attributeDTOs;
    }

    /**
     * @return PaginationDTO
     */
    public function getPaginationDTO()
    {
        return $this->paginationDTOBuilder->build();
    }
}
