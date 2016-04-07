<?php
namespace inklabs\kommerce\EntityDTO;

class InventoryLocationDTO
{
    use IdDTOTrait, TimeDTOTrait;

    /** @var string */
    public $name;

    /** @var string */
    public $code;

    /** @var WarehouseDTO */
    public $warehouse;
}
