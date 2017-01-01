<?php
namespace inklabs\kommerce\Action\Attribute\Query;

use inklabs\kommerce\EntityDTO\Builder\AttributeValueDTOBuilder;

interface GetAttributeValueResponseInterface
{
    public function setAttributeValueDTOBuilder(AttributeValueDTOBuilder $attributeValueDTOBuilder);
}
