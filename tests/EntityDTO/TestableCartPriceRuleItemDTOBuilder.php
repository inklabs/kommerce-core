<?php
namespace inklabs\kommerce\tests\EntityDTO;

use inklabs\kommerce\EntityDTO\Builder\AbstractCartPriceRuleItemDTOBuilder;
use inklabs\kommerce\tests\Entity\TestableCartPriceRuleItem;

class TestableCartPriceRuleItemDTOBuilder extends AbstractCartPriceRuleItemDTOBuilder
{
    public function __construct(TestableCartPriceRuleItem $testableCartPriceRuleItem)
    {
        $this->cartPriceRuleItemDTO = new TestableCartPriceRuleItemDTO;

        parent::__construct($testableCartPriceRuleItem);
    }
}
