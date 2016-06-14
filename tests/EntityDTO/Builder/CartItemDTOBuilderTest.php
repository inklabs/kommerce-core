<?php
namespace inklabs\kommerce\EntityDTO;

use inklabs\kommerce\EntityDTO\CartItemOptionProductDTO;
use inklabs\kommerce\EntityDTO\CartItemOptionValueDTO;
use inklabs\kommerce\EntityDTO\CartItemTextOptionValueDTO;
use inklabs\kommerce\EntityDTO\ImageDTO;
use inklabs\kommerce\EntityDTO\PriceDTO;
use inklabs\kommerce\EntityDTO\ProductDTO;
use inklabs\kommerce\EntityDTO\ProductQuantityDiscountDTO;
use inklabs\kommerce\EntityDTO\TagDTO;
use inklabs\kommerce\tests\Helper\TestCase\EntityDTOBuilderTestCase;

class CartItemDTOBuilderTest extends EntityDTOBuilderTestCase
{
    public function testBuild()
    {
        $pricing = $this->dummyData->getPricing();
        $cartItem = $this->dummyData->getCartItemFull();

        $cartItemDTO = $this->getDTOBuilderFactory()
            ->getCartItemDTOBuilder($cartItem)
            ->withAllData($pricing)
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
