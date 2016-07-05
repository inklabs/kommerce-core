<?php
namespace inklabs\kommerce\EntityDTO\Builder;

use inklabs\kommerce\Entity\PromotionRedemptionTrait;
use inklabs\kommerce\EntityDTO\PromotionRedemptionDTOTrait;

/**
 * @property PromotionRedemptionTrait entity
 * @property PromotionRedemptionDTOTrait entityDTO
 */
trait PromotionRedemptionDTOBuilderTrait
{
    public function setRedemption()
    {
        $this->entityDTO->redemptions = $this->entity->getRedemptions();
        $this->entityDTO->maxRedemptions = $this->entity->getMaxRedemptions();
    }
}
