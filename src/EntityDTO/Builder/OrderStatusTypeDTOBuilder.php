<?php
namespace inklabs\kommerce\EntityDTO\Builder;

use inklabs\kommerce\Entity\OrderStatusType;
use inklabs\kommerce\EntityDTO\OrderStatusTypeDTO;

/**
 * @method OrderStatusTypeDTO build()
 */
class OrderStatusTypeDTOBuilder extends AbstractIntegerTypeDTOBuilder
{
    /** @var OrderStatusType */
    protected $entity;

    /** @var OrderStatusTypeDTO */
    protected $entityDTO;

    protected function getEntityDTO()
    {
        return new OrderStatusTypeDTO;
    }

    protected function preBuild()
    {
        $this->entityDTO->isPending = $this->entity->isPending();
        $this->entityDTO->isProcessing = $this->entity->isProcessing();
        $this->entityDTO->isPartiallyShipped = $this->entity->isPartiallyShipped();
        $this->entityDTO->isShipped = $this->entity->isShipped();
        $this->entityDTO->isComplete = $this->entity->isComplete();
        $this->entityDTO->isCanceled = $this->entity->isCanceled();
    }
}
