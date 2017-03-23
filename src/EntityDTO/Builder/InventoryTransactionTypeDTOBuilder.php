<?php
namespace inklabs\kommerce\EntityDTO\Builder;

use inklabs\kommerce\Entity\InventoryTransactionType;
use inklabs\kommerce\EntityDTO\InventoryTransactionTypeDTO;

/**
 * @method InventoryTransactionTypeDTO build()
 */
class InventoryTransactionTypeDTOBuilder extends AbstractIntegerTypeDTOBuilder
{
    /** @var InventoryTransactionType */
    protected $entity;

    /** @var InventoryTransactionTypeDTO */
    protected $entityDTO;

    protected function getEntityDTO()
    {
        return new InventoryTransactionTypeDTO;
    }

    public function __construct(InventoryTransactionType $type)
    {
        parent::__construct($type);

        $this->entityDTO->isMove = $this->entity->isMove();
        $this->entityDTO->isHold = $this->entity->isHold();
        $this->entityDTO->isNewProducts = $this->entity->isNewProducts();
        $this->entityDTO->isShipped = $this->entity->isShipped();
        $this->entityDTO->isReturned = $this->entity->isReturned();
        $this->entityDTO->isPromotion = $this->entity->isPromotion();
        $this->entityDTO->isDamaged = $this->entity->isDamaged();
        $this->entityDTO->isShrinkage = $this->entity->isShrinkage();
    }
}
