<?php
namespace inklabs\kommerce\EntityDTO\Builder;

use inklabs\kommerce\Entity\OrderAddress;
use inklabs\kommerce\EntityDTO\OrderAddressDTO;

class OrderAddressDTOBuilder
{
    /** @var OrderAddress */
    protected $orderAddress;

    /** @var OrderAddressDTO */
    protected $orderAddressDTO;

    public function __construct(OrderAddress $orderAddress)
    {
        $this->orderAddress = $orderAddress;

        $this->orderAddressDTO = new OrderAddressDTO;
        $this->orderAddressDTO->firstName = $this->orderAddress->firstName;
        $this->orderAddressDTO->lastName  = $this->orderAddress->lastName;
        $this->orderAddressDTO->fullName  = $this->orderAddress->getFullName();
        $this->orderAddressDTO->company   = $this->orderAddress->company;
        $this->orderAddressDTO->address1  = $this->orderAddress->address1;
        $this->orderAddressDTO->address2  = $this->orderAddress->address2;
        $this->orderAddressDTO->city      = $this->orderAddress->city;
        $this->orderAddressDTO->state     = $this->orderAddress->state;
        $this->orderAddressDTO->zip5      = $this->orderAddress->zip5;
        $this->orderAddressDTO->zip4      = $this->orderAddress->zip4;
        $this->orderAddressDTO->phone     = $this->orderAddress->phone;
        $this->orderAddressDTO->email     = $this->orderAddress->email;
    }

    public function build()
    {
        return $this->orderAddressDTO;
    }
}
