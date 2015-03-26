<?php
namespace inklabs\kommerce\Entity\View;

use inklabs\kommerce\Entity as Entity;

class Address
{
    public $attention;
    public $company;
    public $address1;
    public $address2;
    public $city;
    public $state;
    public $zip5;
    public $zip4;

    /** @var Point */
    public $point;

    public function __construct(Entity\Address $address)
    {
        $this->attention = $address->getAttention();
        $this->company   = $address->getCompany();
        $this->address1  = $address->getaddress1();
        $this->address2  = $address->getaddress2();
        $this->city      = $address->getcity();
        $this->state     = $address->getstate();
        $this->zip5      = $address->getzip5();
        $this->zip4      = $address->getzip4();
        $this->point     = $address->getPoint()->getView();
    }
}
