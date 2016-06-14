<?php
namespace inklabs\kommerce\EntityDTO\Builder;

use inklabs\kommerce\Entity\Parcel;
use inklabs\kommerce\EntityDTO\ParcelDTO;

class ParcelDTOBuilder implements DTOBuilderInterface
{
    use TimeDTOBuilderTrait;

    /** @var Parcel */
    protected $entity;

    /** @var ParcelDTO */
    protected $entityDTO;

    public function __construct(Parcel $parcel)
    {
        $this->entity = $parcel;

        $this->entityDTO = new ParcelDTO;
        $this->setTime();
        $this->entityDTO->externalId = $this->entity->getExternalId();
        $this->entityDTO->length     = $this->entity->getLength();
        $this->entityDTO->width      = $this->entity->getWidth();
        $this->entityDTO->height     = $this->entity->getHeight();
        $this->entityDTO->weight     = $this->entity->getWeight();
        $this->entityDTO->predefinedPackage = $this->entity->getPredefinedPackage();
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
