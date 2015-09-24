<?php
namespace inklabs\kommerce\tests\EntityDTO;

use inklabs\kommerce\EntityDTO\Builder\AbstractCartPriceRuleItemDTOBuilder;

class TestableCartPriceRuleItemInvalidDTOBuilder extends AbstractCartPriceRuleItemDTOBuilder
{
    public function __construct(TestableCartPriceRuleItemInvalid $testableCartPriceRuleItem)
    {
        parent::__construct($testableCartPriceRuleItem);
    }
}
