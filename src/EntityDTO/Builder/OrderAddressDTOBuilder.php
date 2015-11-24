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
        $this->orderAddressDTO->country   = $this->orderAddress->getCountry();
        $this->orderAddressDTO->isResidential = $this->orderAddress->isResidential();
    }

    public static function createFromDTO(OrderAddressDTO $orderAddressDTO)
    {
        $orderAddress = new OrderAddress;
        $orderAddress->firstName = $orderAddressDTO->firstName;
        $orderAddress->lastName = $orderAddressDTO->lastName;
        $orderAddress->company = $orderAddressDTO->company;
        $orderAddress->address1 = $orderAddressDTO->address1;
        $orderAddress->address2 = $orderAddressDTO->address2;
        $orderAddress->city = $orderAddressDTO->city;
        $orderAddress->state = $orderAddressDTO->state;
        $orderAddress->zip5 = $orderAddressDTO->zip5;
        $orderAddress->zip4 = $orderAddressDTO->zip4;
        $orderAddress->phone = $orderAddressDTO->phone;
        $orderAddress->email = $orderAddressDTO->email;
        $orderAddress->setCountry($orderAddressDTO->country);
        $orderAddress->setIsResidential($orderAddressDTO->isResidential);

        return $orderAddress;
    }

    public function build()
    {
        return $this->orderAddressDTO;
    }
}
