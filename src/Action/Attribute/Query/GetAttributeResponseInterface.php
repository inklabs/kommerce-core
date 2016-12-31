<?php
namespace inklabs\kommerce\Action\Attribute\Query;

use inklabs\kommerce\EntityDTO\Builder\AttributeDTOBuilder;

interface GetAttributeResponseInterface
{
    public function setAttributeDTOBuilder(AttributeDTOBuilder $attributeDTOBuilder);
}
