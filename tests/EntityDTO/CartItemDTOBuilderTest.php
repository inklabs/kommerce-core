<?php
namespace inklabs\kommerce\EntityDTO;

use inklabs\kommerce\Lib\Pricing;
use inklabs\kommerce\tests\Helper;

class CartItemDTOBuilderTest extends Helper\DoctrineTestCase
{
    public function testBuild()
    {
        $cartItem = $this->getDummyFullCartItem();

        $viewCartItem = $cartItem->getDTOBuilder()
            ->withAllData(new Pricing)
            ->build();

        $this->assertTrue($viewCartItem->price instanceof PriceDTO);
        $this->assertTrue($viewCartItem->product instanceof ProductDTO);
        $this->assertTrue($viewCartItem->cartItemOptionProducts[0] instanceof CartItemOptionProductDTO);
        $this->assertTrue($viewCartItem->cartItemOptionValues[0] instanceof CartItemOptionValueDTO);
        $this->assertTrue($viewCartItem->cartItemTextOptionValues[0] instanceof CartItemTextOptionValueDTO);
    }
}
