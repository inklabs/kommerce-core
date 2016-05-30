<?php
namespace inklabs\kommerce\EntityDTO\Builder;

use inklabs\kommerce\Entity\AbstractPromotion;
use inklabs\kommerce\EntityDTO\AbstractPromotionDTO;

abstract class AbstractPromotionDTOBuilder
{
    /** @var AbstractPromotion */
    protected $promotion;

    /** @var AbstractPromotionDTO */
    protected $promotionDTO;

    /** @var DTOBuilderFactoryInterface */
    protected $dtoBuilderFactory;

    abstract protected function initializePromotionDTO();

    public function __construct(AbstractPromotion $promotion, DTOBuilderFactoryInterface $dtoBuilderFactory)
    {
        $this->promotion = $promotion;
        $this->dtoBuilderFactory = $dtoBuilderFactory;

        $this->initializePromotionDTO();
        $this->promotionDTO->id             = $this->promotion->getId();
        $this->promotionDTO->name           = $this->promotion->getName();
        $this->promotionDTO->value          = $this->promotion->getValue();
        $this->promotionDTO->redemptions    = $this->promotion->getRedemptions();
        $this->promotionDTO->maxRedemptions = $this->promotion->getMaxRedemptions();
        $this->promotionDTO->start          = $this->promotion->getStart();
        $this->promotionDTO->end            = $this->promotion->getEnd();
        $this->promotionDTO->created        = $this->promotion->getCreated();
        $this->promotionDTO->updated        = $this->promotion->getUpdated();

        $this->promotionDTO->isRedemptionCountValid = $this->promotion->isRedemptionCountValid();

        $this->promotionDTO->type = $this->dtoBuilderFactory->getPromotionTypeDTOBuilder($this->promotion->getType())
            ->build();

        if ($this->promotionDTO->start !== null) {
            $this->promotionDTO->startFormatted = $this->promotionDTO->start->format('Y-m-d');
        }

        if ($this->promotionDTO->end !== null) {
            $this->promotionDTO->endFormatted = $this->promotionDTO->end->format('Y-m-d');
        }
    }

    protected function preBuild()
    {
    }

    public function build()
    {
        $this->preBuild();
        unset($this->promotion);
        return $this->promotionDTO;
    }
}
