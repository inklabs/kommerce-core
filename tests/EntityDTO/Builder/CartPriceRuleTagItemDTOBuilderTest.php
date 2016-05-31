<?php
namespace inklabs\kommerce\tests\EntityDTO\Builder;

use inklabs\kommerce\EntityDTO\CartPriceRuleTagItemDTO;
use inklabs\kommerce\EntityDTO\TagDTO;

class CartPriceRuleTagItemDTOBuilderTest extends AbstractCartPriceRuleItemDTOBuilderTest
{
    public function testBuildWithAllData()
    {
        $item = $this->getItem();

        $itemDTO = $this->getDTOBuilderFactory()->getCartPriceRuleTagItemDTOBuilder($item)
            ->withAllData()
            ->build();

        $this->assertTrue($itemDTO instanceof CartPriceRuleTagItemDTO);
        $this->assertTrue($itemDTO->tag instanceof TagDTO);
    }

    protected function getItem()
    {
        return $this->dummyData->getCartPriceRuleTagItem();
    }
}
