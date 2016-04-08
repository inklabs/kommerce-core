<?php
namespace inklabs\kommerce\tests\Helper\EntityDTO;

use inklabs\kommerce\Entity\AbstractCartPriceRuleItem;
use inklabs\kommerce\Entity\CartItem;

class TestableCartPriceRuleItemInvalid extends AbstractCartPriceRuleItem
{
    public function getDTOBuilder()
    {
        return new TestableCartPriceRuleItemInvalidDTOBuilder($this);
    }

    public function matches(CartItem $cartItem)
    {
    }
}
