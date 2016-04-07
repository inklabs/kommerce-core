<?php
namespace inklabs\kommerce\EntityDTO;

class InventoryTransactionDTO
{
    use IdDTOTrait, TimeDTOTrait;

    /** @var int */
    public $debitQuantity;

    /** @var int */
    public $creditQuantity;

    /** @var string */
    public $memo;

    /** @var InventoryLocationDTO */
    public $inventoryLocation;

    /** @var ProductDTO */
    public $product;

    /** @var InventoryTransactionTypeDTO */
    public $type;
}
