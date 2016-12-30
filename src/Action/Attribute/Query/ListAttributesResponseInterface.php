<?php
namespace inklabs\kommerce\Action\Attribute\Query;

use inklabs\kommerce\EntityDTO\Builder\AttributeDTOBuilder;
use inklabs\kommerce\EntityDTO\Builder\PaginationDTOBuilder;

interface ListAttributesResponseInterface
{
    public function addAttributeDTOBuilder(AttributeDTOBuilder $attributeDTOBuilder);
    public function setPaginationDTOBuilder(PaginationDTOBuilder $paginationDTOBuilder);
}
