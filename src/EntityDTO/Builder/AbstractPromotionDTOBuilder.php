<?php
namespace inklabs\kommerce\EntityDTO\Builder;

use inklabs\kommerce\Entity\AbstractPromotion;
use inklabs\kommerce\EntityDTO\PromotionDTO;
use inklabs\kommerce\Lib\BaseConvert;
use RuntimeException;

abstract class AbstractPromotionDTOBuilder
{
    /** @var AbstractPromotion */
    protected $promotion;

    /** @var PromotionDTO */
    protected $promotionDTO;

    public function __construct(AbstractPromotion $promotionInvalid)
    {
        if ($this->promotionDTO === null) {
            throw new RuntimeException('promotionDTO has not been initialized');
        }

        $this->promotion = $promotionInvalid;

        $this->promotionDTO->id             = $this->promotion->getId();
        $this->promotionDTO->encodedId      = BaseConvert::encode($this->promotion->getId());
        $this->promotionDTO->name           = $this->promotion->getName();
        $this->promotionDTO->type           = $this->promotion->getType();
        $this->promotionDTO->typeText       = $this->promotion->getTypeText();
        $this->promotionDTO->value          = $this->promotion->getValue();
        $this->promotionDTO->redemptions    = $this->promotion->getRedemptions();
        $this->promotionDTO->maxRedemptions = $this->promotion->getMaxRedemptions();
        $this->promotionDTO->start          = $this->promotion->getStart();
        $this->promotionDTO->end            = $this->promotion->getEnd();
        $this->promotionDTO->created        = $this->promotion->getCreated();
        $this->promotionDTO->updated        = $this->promotion->getUpdated();

        $this->promotionDTO->isRedemptionCountValid = $this->promotion->isRedemptionCountValid();

        if ($this->promotionDTO->start !== null) {
            $this->promotionDTO->startFormatted = $this->promotionDTO->start->format('Y-m-d');
        }

        if ($this->promotionDTO->end !== null) {
            $this->promotionDTO->endFormatted = $this->promotionDTO->end->format('Y-m-d');
        }
    }

    public function build()
    {
        return $this->promotionDTO;
    }
}
