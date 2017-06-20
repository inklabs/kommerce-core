<?php
namespace inklabs\kommerce\tests\Helper\Entity;

use inklabs\kommerce\Entity\AbstractCartPriceRuleItem;
use inklabs\kommerce\Entity\CartItem;

class FakeCartPriceRuleItem extends AbstractCartPriceRuleItem
{
    public function matches(CartItem $cartItem): bool
    {
        return false;
    }
}
