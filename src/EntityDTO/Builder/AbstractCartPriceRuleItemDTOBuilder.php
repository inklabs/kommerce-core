<?php
namespace inklabs\kommerce\EntityDTO\Builder;

use inklabs\kommerce\Entity\AbstractCartPriceRuleItem;
use inklabs\kommerce\EntityDTO\AbstractCartPriceRuleItemDTO;

abstract class AbstractCartPriceRuleItemDTOBuilder implements DTOBuilderInterface
{
    use IdDTOBuilderTrait, TimeDTOBuilderTrait;

    /** @var AbstractCartPriceRuleItem */
    protected $entity;

    /** @var AbstractCartPriceRuleItemDTO */
    protected $entityDTO;

    /** @var DTOBuilderFactoryInterface */
    protected $dtoBuilderFactory;

    /**
     * @return AbstractCartPriceRuleItemDTO
     */
    abstract protected function getEntityDTO();

    public function __construct(AbstractCartPriceRuleItem $item, DTOBuilderFactoryInterface $dtoBuilderFactory)
    {
        $this->entity = $item;
        $this->dtoBuilderFactory = $dtoBuilderFactory;

        $this->entityDTO = $this->getEntityDTO();
        $this->setId();
        $this->setTime();
        $this->entityDTO->quantity = $this->entity->getQuantity();
    }

    protected function preBuild()
    {
    }

    public function build()
    {
        $this->preBuild();
        return $this->entityDTO;
    }
}
