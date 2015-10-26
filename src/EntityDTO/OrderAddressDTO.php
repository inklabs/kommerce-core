<?php
namespace inklabs\kommerce\EntityDTO;

class OrderAddressDTO
{
    public $firstName;
    public $lastName;
    public $fullName;
    public $company;
    public $address1;
    public $address2;
    public $city;
    public $state;
    public $zip5;
    public $zip4;
    public $phone;
    public $email;

    /** @var string */
    public $country;

    /** @var boolean */
    public $isResidential;
}
