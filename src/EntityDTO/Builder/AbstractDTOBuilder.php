<?php
namespace inklabs\kommerce\EntityDTO\Builder;

use inklabs\kommerce\Entity\Accessor\Id;
use inklabs\kommerce\Entity\Accessor\Time;
use inklabs\kommerce\Lib\BaseConvert;
use stdClass;

abstract class AbstractDTOBuilder implements DTOBuilderInterface
{
    /** @var Id|Time */
    protected $entity;

    /** @var stdClass */
    protected $entityDTO;

    public function withAllData()
    {
        return $this;
    }

    public function build()
    {
        return $this->entityDTO;
    }

    protected function setId()
    {
        $this->entityDTO->id = $this->entity->getId();
        $this->entityDTO->encodedId = BaseConvert::encode($this->entity->getId());
    }

    protected function setTimestamps()
    {
        $this->setCreated();
        $this->entityDTO->updated = $this->entity->getUpdated();
    }

    protected function setCreated()
    {
        $this->entityDTO->created = $this->entity->getCreated();
    }
}
