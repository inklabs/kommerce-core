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
    protected $type;

    /** @var InventoryTransactionTypeDTO */
    protected $typeDTO;

    protected function getTypeDTO()
    {
        return new InventoryTransactionTypeDTO;
    }
}
