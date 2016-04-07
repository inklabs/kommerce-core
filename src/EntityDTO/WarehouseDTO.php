<?php
namespace inklabs\kommerce\EntityDTO;

class WarehouseDTO
{
    use IdDTOTrait, TimeDTOTrait;

    /** @var string */
    public $name;

    /** @var AddressDTO */
    public $address;
}
