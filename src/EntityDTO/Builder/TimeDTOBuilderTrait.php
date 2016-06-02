<?php
namespace inklabs\kommerce\EntityDTO\Builder;

use inklabs\kommerce\Entity\TimeTrait;
use inklabs\kommerce\EntityDTO\TimeDTOTrait;

/**
 * @property TimeTrait entity
 * @property TimeDTOTrait entityDTO
 */
trait TimeDTOBuilderTrait
{
    public function setTime()
    {
        $this->entityDTO->created = $this->entity->getCreated();
        $this->entityDTO->updated = $this->entity->getUpdated();
    }
}
