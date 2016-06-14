<?php
namespace inklabs\kommerce\EntityDTO\Builder;

use inklabs\kommerce\Entity\Point;
use inklabs\kommerce\EntityDTO\PointDTO;

class PointDTOBuilder implements DTOBuilderInterface
{
    /** @var Point */
    protected $entity;

    /** @var PointDTO */
    protected $entityDTO;

    public function __construct(Point $point)
    {
        $this->entity = $point;

        $this->entityDTO = new PointDTO;
        $this->entityDTO->latitude = $this->entity->getLatitude();
        $this->entityDTO->longitude = $this->entity->getLongitude();
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
