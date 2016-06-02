<?php
namespace inklabs\kommerce\EntityDTO\Builder;

use inklabs\kommerce\Entity\OrderAddress;
use inklabs\kommerce\EntityDTO\OrderAddressDTO;

class OrderAddressDTOBuilder implements DTOBuilderInterface
{
    /** @var OrderAddress */
    protected $entity;

    /** @var OrderAddressDTO */
    protected $entityDTO;

    public function __construct(OrderAddress $orderAddress)
    {
        $this->entity = $orderAddress;

        $this->entityDTO = new OrderAddressDTO;
        $this->entityDTO->firstName = $this->entity->getFirstName();
        $this->entityDTO->lastName  = $this->entity->getLastName();
        $this->entityDTO->fullName  = $this->entity->getFullName();
        $this->entityDTO->company   = $this->entity->getCompany();
        $this->entityDTO->address1  = $this->entity->getAddress1();
        $this->entityDTO->address2  = $this->entity->getAddress2();
        $this->entityDTO->city      = $this->entity->getCity();
        $this->entityDTO->state     = $this->entity->getState();
        $this->entityDTO->zip5      = $this->entity->getZip5();
        $this->entityDTO->zip4      = $this->entity->getZip4();
        $this->entityDTO->phone     = $this->entity->getPhone();
        $this->entityDTO->email     = $this->entity->getEmail();
        $this->entityDTO->country   = $this->entity->getCountry();
        $this->entityDTO->isResidential = $this->entity->isResidential();
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

    protected function preBuild()
    {
    }

    public function build()
    {
        $this->preBuild();
        return $this->entityDTO;
    }
}
