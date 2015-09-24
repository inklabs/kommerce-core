<?php
namespace inklabs\kommerce\tests\EntityDTO;

use inklabs\kommerce\Entity;
use inklabs\kommerce\Entity\AbstractCartPriceRuleItem;

class TestableCartPriceRuleItemInvalid extends AbstractCartPriceRuleItem
{
    public function getDTOBuilder()
    {
        return new TestableCartPriceRuleItemInvalidDTOBuilder($this);
    }

    public function matches(Entity\CartItem $cartItem)
    {
    }
}
