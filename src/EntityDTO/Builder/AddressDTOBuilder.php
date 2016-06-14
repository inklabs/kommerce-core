<?php
namespace inklabs\kommerce\EntityDTO\Builder;

use inklabs\kommerce\Entity\Address;
use inklabs\kommerce\EntityDTO\AddressDTO;

class AddressDTOBuilder implements DTOBuilderInterface
{
    /** @var Address */
    protected $entity;

    /** @var AddressDTO */
    protected $entityDTO;

    /** @var DTOBuilderFactoryInterface */
    protected $dtoBuilderFactory;

    public function __construct(Address $address, DTOBuilderFactoryInterface $dtoBuilderFactory)
    {
        $this->entity = $address;
        $this->dtoBuilderFactory = $dtoBuilderFactory;

        $this->entityDTO = new AddressDTO;
        $this->entityDTO->attention = $this->entity->getAttention();
        $this->entityDTO->company   = $this->entity->getCompany();
        $this->entityDTO->address1  = $this->entity->getaddress1();
        $this->entityDTO->address2  = $this->entity->getaddress2();
        $this->entityDTO->city      = $this->entity->getcity();
        $this->entityDTO->state     = $this->entity->getstate();
        $this->entityDTO->zip5      = $this->entity->getzip5();
        $this->entityDTO->zip4      = $this->entity->getzip4();

        $this->entityDTO->point     = $this->dtoBuilderFactory
            ->getPointDTOBuilder($this->entity->getPoint())
            ->build();
    }

    protected function preBuild()
    {
    }

    public function build()
    {
        $this->preBuild();
        unset($this->entity);
        return $this->entityDTO;
    }
}
