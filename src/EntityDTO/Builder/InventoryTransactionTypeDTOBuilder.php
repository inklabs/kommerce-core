<?php
namespace inklabs\kommerce\EntityDTO\Builder;

use inklabs\kommerce\Entity\InventoryTransactionType;
use inklabs\kommerce\EntityDTO\InventoryTransactionTypeDTO;

/**
 * @method InventoryTransactionTypeDTO build()
 */
class InventoryTransactionTypeDTOBuilder extends AbstractIntegerTypeDTOBuilder
{
    protected function getEntityDTO()
    {
        return new InventoryTransactionTypeDTO;
    }
}
