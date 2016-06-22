<?php
namespace inklabs\kommerce\Action\Option\Query;

use inklabs\kommerce\EntityDTO\Builder\PaginationDTOBuilder;
use inklabs\kommerce\EntityDTO\Builder\OptionDTOBuilder;

interface ListOptionsResponseInterface
{
    public function setPaginationDTOBuilder(PaginationDTOBuilder$paginationDTOBuilder);
    public function addOptionDTOBuilder(OptionDTOBuilder $optionDTOBuilder);
}
