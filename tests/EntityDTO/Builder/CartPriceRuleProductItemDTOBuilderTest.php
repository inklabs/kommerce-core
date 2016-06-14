<?php
namespace inklabs\kommerce\tests\EntityDTO\Builder;

use inklabs\kommerce\Entity\CartPriceRuleProductItem;
use inklabs\kommerce\EntityDTO\CartPriceRuleProductItemDTO;
use inklabs\kommerce\EntityDTO\ProductDTO;

class CartPriceRuleProductItemDTOBuilderTest extends AbstractCartPriceRuleItemDTOBuilderTest
{
    /**
     * @return CartPriceRuleProductItem
     */
    protected function getItem()
    {
        return $this->dummyData->getCartPriceRuleProductItem();
    }

    /**
     * @return CartPriceRuleProductItemDTO
     */
    protected function getItemDTO()
    {
        return $this->getDTOBuilderFactory()
            ->getCartPriceRuleProductItemDTOBuilder($this->getItem())
            ->withAllData()
            ->build();
    }

    public function testBuildWithAllData()
    {
        $item = $this->getItem();
        $itemDTO = $this->getItemDTO();

        $this->assertTrue($itemDTO instanceof CartPriceRuleProductItemDTO);
        $this->assertTrue($itemDTO->product instanceof ProductDTO);
    }
}
