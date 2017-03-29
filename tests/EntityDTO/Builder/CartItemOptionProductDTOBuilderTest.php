<?php
namespace inklabs\kommerce\EntityDTO;

use inklabs\kommerce\tests\Helper\TestCase\EntityDTOBuilderTestCase;

class CartItemOptionProductDTOBuilderTest extends EntityDTOBuilderTestCase
{
    public function testBuild()
    {
        $cartItemOptionProduct = $this->dummyData->getCartItemOptionProduct();

        $cartItemOptionProductDTO = $this->getDTOBuilderFactory()
            ->getCartItemOptionProductDTOBuilder($cartItemOptionProduct)
            ->withAllData($this->dummyData->getPricing())
            ->build();

        $this->assertTrue($cartItemOptionProductDTO instanceof CartItemOptionProductDTO);
        $this->assertTrue($cartItemOptionProductDTO->optionProduct instanceof OptionProductDTO);
        $this->assertTrue($cartItemOptionProductDTO->optionProduct->option instanceof OptionDTO);
        $this->assertTrue($cartItemOptionProductDTO->optionProduct->product instanceof ProductDTO);
    }
}
