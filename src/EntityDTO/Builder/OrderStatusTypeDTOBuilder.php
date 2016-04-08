<?php
namespace inklabs\kommerce\EntityDTO\Builder;

use inklabs\kommerce\Entity\OrderStatusType;
use inklabs\kommerce\EntityDTO\OrderStatusTypeDTO;

class OrderStatusTypeDTOBuilder extends AbstractIntegerTypeDTOBuilder
{
    /** @var OrderStatusType */
    protected $type;

    /** @var OrderStatusTypeDTO */
    protected $typeDTO;

    protected function getTypeDTO()
    {
        return new OrderStatusTypeDTO;
    }
}
