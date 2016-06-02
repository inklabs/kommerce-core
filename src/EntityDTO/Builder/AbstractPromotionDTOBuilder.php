<?php
namespace inklabs\kommerce\EntityDTO\Builder;

use inklabs\kommerce\Entity\AbstractPromotion;
use inklabs\kommerce\EntityDTO\AbstractPromotionDTO;

abstract class AbstractPromotionDTOBuilder implements DTOBuilderInterface
{
    use IdDTOBuilderTrait, TimeDTOBuilderTrait;

    /** @var AbstractPromotion */
    protected $entity;

    /** @var AbstractPromotionDTO */
    protected $entityDTO;

    /** @var DTOBuilderFactoryInterface */
    protected $dtoBuilderFactory;

    /**
     * @return AbstractPromotionDTO
     */
    abstract protected function getEntityDTO();

    public function __construct(AbstractPromotion $promotion, DTOBuilderFactoryInterface $dtoBuilderFactory)
    {
        $this->entity = $promotion;
        $this->dtoBuilderFactory = $dtoBuilderFactory;

        $this->entityDTO = $this->getEntityDTO();
        $this->setId();
        $this->setTime();
        $this->entityDTO->name           = $this->entity->getName();
        $this->entityDTO->value          = $this->entity->getValue();
        $this->entityDTO->redemptions    = $this->entity->getRedemptions();
        $this->entityDTO->maxRedemptions = $this->entity->getMaxRedemptions();
        $this->entityDTO->start          = $this->entity->getStart();
        $this->entityDTO->end            = $this->entity->getEnd();

        $this->entityDTO->isRedemptionCountValid = $this->entity->isRedemptionCountValid();

        $this->entityDTO->type = $this->dtoBuilderFactory->getPromotionTypeDTOBuilder($this->entity->getType())
            ->build();

        if ($this->entityDTO->start !== null) {
            $this->entityDTO->startFormatted = $this->entityDTO->start->format('Y-m-d');
        }

        if ($this->entityDTO->end !== null) {
            $this->entityDTO->endFormatted = $this->entityDTO->end->format('Y-m-d');
        }
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
