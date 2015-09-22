<?php
namespace inklabs\kommerce\EntityDTO;

class WarehouseDTO
{
    public $id;
    public $encodedId;
    public $name;
    public $created;
    public $updated;

    /** @var AddressDTO */
    public $address;
}
