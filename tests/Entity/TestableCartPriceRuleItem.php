<?php
namespace inklabs\kommerce\tests\Entity;

use inklabs\kommerce\Entity;
use inklabs\kommerce\tests\EntityDTO\TestableCartPriceRuleItemDTOBuilder;
use inklabs\kommerce\Entity\AbstractCartPriceRuleItem;

class TestableCartPriceRuleItem extends AbstractCartPriceRuleItem
{
    public function getDTOBuilder()
    {
        return new TestableCartPriceRuleItemDTOBuilder($this);
    }

    public function matches(Entity\CartItem $cartItem)
    {
    }
}
