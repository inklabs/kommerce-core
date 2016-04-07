<?php
namespace inklabs\kommerce\EntityDTO;

class OrderAddressDTO
{
    /** @var int */
    public $sortOrder;

    /** @var string */
    public $firstName;

    /** @var string */
    public $lastName;

    /** @var string */
    public $fullName;

    /** @var string */
    public $company;

    /** @var string */
    public $address1;

    /** @var string */
    public $address2;

    /** @var string */
    public $city;

    /** @var string */
    public $state;

    /** @var string */
    public $zip5;

    /** @var string */
    public $zip4;

    /** @var string */
    public $phone;

    /** @var string */
    public $email;

    /** @var string */
    public $country;

    /** @var boolean */
    public $isResidential;
}
