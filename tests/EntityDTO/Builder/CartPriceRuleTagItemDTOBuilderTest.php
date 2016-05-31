<?php
namespace inklabs\kommerce\tests\EntityDTO\Builder;

use inklabs\kommerce\Entity\CartPriceRuleTagItem;
use inklabs\kommerce\EntityDTO\CartPriceRuleTagItemDTO;
use inklabs\kommerce\EntityDTO\TagDTO;

class CartPriceRuleTagItemDTOBuilderTest extends AbstractCartPriceRuleItemDTOBuilderTest
{
    /**
     * @return CartPriceRuleTagItem
     */
    protected function getItem()
    {
        return $this->dummyData->getCartPriceRuleTagItem();
    }

    /**
     * @return CartPriceRuleTagItemDTO
     */
    protected function getItemDTO()
    {
        return $this->getDTOBuilderFactory()
            ->getCartPriceRuleTagItemDTOBuilder($this->getItem())
            ->withAllData()
            ->build();
    }

    public function testBuildWithAllData()
    {
        $item = $this->getItem();
        $itemDTO = $this->getItemDTO();

        $this->assertTrue($itemDTO instanceof CartPriceRuleTagItemDTO);
        $this->assertTrue($itemDTO->tag instanceof TagDTO);
    }
}
