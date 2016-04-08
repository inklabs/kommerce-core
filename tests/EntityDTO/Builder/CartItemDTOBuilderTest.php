<?php
namespace inklabs\kommerce\EntityDTO;

use inklabs\kommerce\Lib\Pricing;
use inklabs\kommerce\tests\Helper;

class CartItemDTOBuilderTest extends Helper\TestCase\EntityDTOBuilderTestCase
{
    public function testBuild()
    {
        $cartItem = $this->dummyData->getCartItemFull();

        $cartItemDTO = $cartItem->getDTOBuilder()
            ->withAllData(new Pricing)
            ->build();

        $this->assertTrue($cartItemDTO->price instanceof PriceDTO);
        $this->assertTrue($cartItemDTO->product instanceof ProductDTO);
        $this->assertTrue($cartItemDTO->product->tags[0] instanceof TagDTO);
        $this->assertTrue($cartItemDTO->product->tags[0]->images[0] instanceof ImageDTO);
        $this->assertTrue($cartItemDTO->product->productQuantityDiscounts[0] instanceof ProductQuantityDiscountDTO);
        $this->assertTrue($cartItemDTO->cartItemOptionProducts[0] instanceof CartItemOptionProductDTO);
        $this->assertTrue($cartItemDTO->cartItemOptionValues[0] instanceof CartItemOptionValueDTO);
        $this->assertTrue($cartItemDTO->cartItemTextOptionValues[0] instanceof CartItemTextOptionValueDTO);
    }
}
