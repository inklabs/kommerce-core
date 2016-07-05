<?php
namespace inklabs\kommerce\EntityDTO\Builder;

use inklabs\kommerce\Entity\PromotionStartEndDateTrait;
use inklabs\kommerce\EntityDTO\PromotionStartEndDateDTOTrait;

/**
 * @property PromotionStartEndDateTrait entity
 * @property PromotionStartEndDateDTOTrait entityDTO
 */
trait PromotionStartEndDateDTOBuilderTrait
{
    public function setStartEndDate()
    {
        $this->entityDTO->start = $this->entity->getStart();
        $this->entityDTO->end = $this->entity->getEnd();

        if ($this->entityDTO->start !== null) {
            $this->entityDTO->startFormatted = $this->entityDTO->start->format('Y-m-d');
        }

        if ($this->entityDTO->end !== null) {
            $this->entityDTO->endFormatted = $this->entityDTO->end->format('Y-m-d');
        }
    }
}
