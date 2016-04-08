<?php
namespace inklabs\kommerce\EntityDTO\Builder;

use inklabs\kommerce\Entity\AbstractCartPriceRuleItem;
use inklabs\kommerce\EntityDTO\AbstractCartPriceRuleItemDTO;

abstract class AbstractCartPriceRuleItemDTOBuilder
{
    /** @var AbstractCartPriceRuleItem */
    protected $item;

    /** @var AbstractCartPriceRuleItemDTO */
    protected $itemDTO;

    /**
     * @return AbstractCartPriceRuleItemDTO
     */
    abstract protected function getItemDTO();

    public function __construct(AbstractCartPriceRuleItem $item)
    {
        $this->item = $item;

        $this->itemDTO = $this->getItemDTO();
        $this->itemDTO->id = $this->item->getId();
        $this->itemDTO->quantity = $this->item->getQuantity();
        $this->itemDTO->created = $this->item->getCreated();
        $this->itemDTO->updated = $this->item->getUpdated();
    }

    public function build()
    {
        return $this->itemDTO;
    }
}
