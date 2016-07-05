<?php
namespace inklabs\kommerce\EntityDTO\Builder;

use inklabs\kommerce\Entity\AbstractPromotion;
use inklabs\kommerce\EntityDTO\AbstractPromotionDTO;

abstract class AbstractPromotionDTOBuilder implements DTOBuilderInterface
{
    use IdDTOBuilderTrait,
        TimeDTOBuilderTrait,
        PromotionStartEndDateDTOBuilderTrait,
        PromotionRedemptionDTOBuilderTrait;

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
        $this->setStartEndDate();
        $this->setRedemption();
        $this->entityDTO->name = $this->entity->getName();
        $this->entityDTO->value = $this->entity->getValue();
        $this->entityDTO->reducesTaxSubtotal = $this->entity->getReducesTaxSubtotal();
        $this->entityDTO->isRedemptionCountValid = $this->entity->isRedemptionCountValid();

        $this->entityDTO->type = $this->dtoBuilderFactory->getPromotionTypeDTOBuilder($this->entity->getType())
            ->build();
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
