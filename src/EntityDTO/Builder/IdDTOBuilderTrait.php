<?php
namespace inklabs\kommerce\EntityDTO\Builder;

use inklabs\kommerce\Entity\IdTrait;
use inklabs\kommerce\EntityDTO\IdDTOTrait;

/**
 * @property IdTrait entity
 * @property IdDTOTrait entityDTO
 */
trait IdDTOBuilderTrait
{
    public function setId()
    {
        $this->entityDTO->id = $this->entity->getId();
    }
}
