<?php
namespace inklabs\kommerce\tests\EntityDTO\Builder;

use inklabs\kommerce\EntityDTO\ProductDTO;

class CartPriceRuleProductItemDTOBuilderTest extends AbstractCartPriceRuleItemDTOBuilderTest
{
    public function testBuildWithAllData()
    {
        $item = $this->getItem();

        $itemDTO = $item->getDTOBuilder()
            ->withAllData()
            ->build();

        $this->assertTrue($itemDTO->product instanceof ProductDTO);
    }

    protected function getItem()
    {
        return $this->dummyData->getCartPriceRuleProductItem();
    }
}
