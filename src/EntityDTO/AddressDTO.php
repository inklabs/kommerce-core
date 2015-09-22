<?php
namespace inklabs\kommerce\EntityDTO;

class AddressDTO
{
    public $attention;
    public $company;
    public $address1;
    public $address2;
    public $city;
    public $state;
    public $zip5;
    public $zip4;

    /** @var PointDTO */
    public $point;
}
