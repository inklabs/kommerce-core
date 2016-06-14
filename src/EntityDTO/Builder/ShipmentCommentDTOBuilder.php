<?php
namespace inklabs\kommerce\EntityDTO\Builder;

use inklabs\kommerce\Entity\ShipmentComment;
use inklabs\kommerce\EntityDTO\ShipmentCommentDTO;

class ShipmentCommentDTOBuilder implements DTOBuilderInterface
{
    use IdDTOBuilderTrait, TimeDTOBuilderTrait;

    /** @var ShipmentComment */
    protected $entity;

    /** @var ShipmentCommentDTO */
    protected $entityDTO;

    public function __construct(ShipmentComment $shipmentComment)
    {
        $this->entity = $shipmentComment;

        $this->entityDTO = new ShipmentCommentDTO;
        $this->setId();
        $this->setTime();
        $this->entityDTO->comment = $this->entity->getComment();
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
