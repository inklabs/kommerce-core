<?php
namespace inklabs\kommerce\EntityDTO\Builder;

use inklabs\kommerce\Entity\AbstractCartPriceRuleItem;
use inklabs\kommerce\EntityDTO\AbstractCartPriceRuleItemDTO;
use RuntimeException;

abstract class AbstractCartPriceRuleItemDTOBuilder
{
    /** @var AbstractCartPriceRuleItem */
    protected $cartPriceRuleItem;

    /** @var AbstractCartPriceRuleItemDTO */
    protected $cartPriceRuleItemDTO;

    public function __construct(AbstractCartPriceRuleItem $cartPriceRuleItem)
    {
        if ($this->cartPriceRuleItemDTO === null) {
            throw new RuntimeException('cartPriceRuleItemDTO has not been initialized');
        }

        $this->cartPriceRuleItem = $cartPriceRuleItem;

        $this->cartPriceRuleItemDTO->id = $this->cartPriceRuleItem->getId();
        $this->cartPriceRuleItemDTO->quantity = $this->cartPriceRuleItem->getQuantity();
        $this->cartPriceRuleItemDTO->created = $this->cartPriceRuleItem->getCreated();
        $this->cartPriceRuleItemDTO->updated = $this->cartPriceRuleItem->getUpdated();
    }

    public function build()
    {
        return $this->cartPriceRuleItemDTO;
    }
}
