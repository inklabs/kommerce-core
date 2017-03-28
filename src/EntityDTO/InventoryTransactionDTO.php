<?php
namespace inklabs\kommerce\EntityDTO;

class InventoryTransactionDTO
{
    use IdDTOTrait, TimeDTOTrait;

    /** @var int */
    public $quantity;

    /** @var string */
    public $memo;

    /** @var InventoryLocationDTO */
    public $inventoryLocation;

    /** @var ProductDTO */
    public $product;

    /** @var InventoryTransactionTypeDTO */
    public $type;
}
