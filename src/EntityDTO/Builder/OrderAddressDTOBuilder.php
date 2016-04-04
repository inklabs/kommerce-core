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
        $this->orderAddressDTO->firstName = $this->orderAddress->getFirstName();
        $this->orderAddressDTO->lastName  = $this->orderAddress->getLastName();
        $this->orderAddressDTO->fullName  = $this->orderAddress->getFullName();
        $this->orderAddressDTO->company   = $this->orderAddress->getCompany();
        $this->orderAddressDTO->address1  = $this->orderAddress->getAddress1();
        $this->orderAddressDTO->address2  = $this->orderAddress->getAddress2();
        $this->orderAddressDTO->city      = $this->orderAddress->getCity();
        $this->orderAddressDTO->state     = $this->orderAddress->getState();
        $this->orderAddressDTO->zip5      = $this->orderAddress->getZip5();
        $this->orderAddressDTO->zip4      = $this->orderAddress->getZip4();
        $this->orderAddressDTO->phone     = $this->orderAddress->getPhone();
        $this->orderAddressDTO->email     = $this->orderAddress->getEmail();
        $this->orderAddressDTO->country   = $this->orderAddress->getCountry();
        $this->orderAddressDTO->isResidential = $this->orderAddress->isResidential();
    }

    /**
     * @param OrderAddressDTO $orderAddressDTO
     * @return OrderAddress
     */
    public static function createFromDTO(OrderAddressDTO $orderAddressDTO)
    {
        $orderAddress = new OrderAddress;
        $orderAddress->setFirstName($orderAddressDTO->firstName);
        $orderAddress->setLastName($orderAddressDTO->lastName);
        $orderAddress->setCompany($orderAddressDTO->company);
        $orderAddress->setAddress1($orderAddressDTO->address1);
        $orderAddress->setAddress2($orderAddressDTO->address2);
        $orderAddress->setCity($orderAddressDTO->city);
        $orderAddress->setState($orderAddressDTO->state);
        $orderAddress->setZip5($orderAddressDTO->zip5);
        $orderAddress->setZip4($orderAddressDTO->zip4);
        $orderAddress->setPhone($orderAddressDTO->phone);
        $orderAddress->setEmail($orderAddressDTO->email);
        $orderAddress->setCountry($orderAddressDTO->country);
        $orderAddress->setIsResidential($orderAddressDTO->isResidential);

        return $orderAddress;
    }

    public function build()
    {
        return $this->orderAddressDTO;
    }
}
