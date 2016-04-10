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
    protected $type;

    /** @var OrderStatusTypeDTO */
    protected $typeDTO;

    /**
     * @return OrderStatusTypeDTO
     */
    protected function getTypeDTO()
    {
        return new OrderStatusTypeDTO;
    }

    public function __construct(OrderStatusType $type)
    {
        parent::__construct($type);

        $this->typeDTO->isPending = $this->type->isPending();
        $this->typeDTO->isProcessing = $this->type->isProcessing();
        $this->typeDTO->isPartiallyShipped = $this->type->isPartiallyShipped();
        $this->typeDTO->isShipped = $this->type->isShipped();
        $this->typeDTO->isComplete = $this->type->isComplete();
        $this->typeDTO->isCanceled = $this->type->isCanceled();
    }
}
