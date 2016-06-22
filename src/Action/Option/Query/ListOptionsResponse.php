<?php
namespace inklabs\kommerce\Action\Option\Query;

use inklabs\kommerce\EntityDTO\Builder\PaginationDTOBuilder;
use inklabs\kommerce\EntityDTO\Builder\OptionDTOBuilder;
use inklabs\kommerce\EntityDTO\PaginationDTO;
use inklabs\kommerce\EntityDTO\OptionDTO;

class ListOptionsResponse implements ListOptionsResponseInterface
{
    /** @var OptionDTOBuilder[] */
    private $optionDTOBuilders = [];

    /** @var PaginationDTOBuilder */
    private $paginationDTOBuilder;

    public function setPaginationDTOBuilder(PaginationDTOBuilder $paginationDTOBuilder)
    {
        $this->paginationDTOBuilder = $paginationDTOBuilder;
    }

    public function addOptionDTOBuilder(OptionDTOBuilder $optionDTOBuilder)
    {
        $this->optionDTOBuilders[] = $optionDTOBuilder;
    }

    /**
     * @return OptionDTO[]
     */
    public function getOptionDTOs()
    {
        $optionDTOs = [];
        foreach ($this->optionDTOBuilders as $optionDTOBuilder) {
            $optionDTOs[] = $optionDTOBuilder->build();
        }
        return $optionDTOs;
    }

    /**
     * @return PaginationDTO
     */
    public function getPaginationDTO()
    {
        return $this->paginationDTOBuilder->build();
    }
}
