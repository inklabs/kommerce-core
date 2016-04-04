<?php
namespace inklabs\kommerce\EntityDTO\Builder;

use inklabs\kommerce\Entity\OrderStatusType;
use inklabs\kommerce\EntityDTO\OrderStatusTypeDTO;

class OrderStatusTypeDTOBuilder
{
    /** @var OrderStatusType */
    protected $orderStatusType;

    /** @var OrderStatusTypeDTO */
    protected $orderStatusTypeDTO;

    public function __construct(OrderStatusType $orderStatusType)
    {
        $this->orderStatusType = $orderStatusType;

        $this->orderStatusTypeDTO = new OrderStatusTypeDTO;
        $this->orderStatusTypeDTO->id = $this->orderStatusType->getId();
        $this->orderStatusTypeDTO->name = $this->orderStatusType->getName();
        $this->orderStatusTypeDTO->nameMap = $this->orderStatusType->getNameMap();
    }

    public function build()
    {
        return $this->orderStatusTypeDTO;
    }
}
