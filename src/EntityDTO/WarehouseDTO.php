<?php
namespace inklabs\kommerce\EntityDTO;

class WarehouseDTO
{
    use IdDTOTrait, TimeDTOTrait;

    public $encodedId;
    public $name;

    /** @var AddressDTO */
    public $address;
}
