<?php
namespace inklabs\kommerce\EntityDTO;

use inklabs\kommerce\Entity\CartItem;
use inklabs\kommerce\Entity\CartItemOptionProduct;
use inklabs\kommerce\Entity\Option;
use inklabs\kommerce\Entity\OptionProduct;
use inklabs\kommerce\Entity\Product;
use inklabs\kommerce\Lib\Pricing;

class CartItemOptionProductDTOBuilderTest extends \PHPUnit_Framework_TestCase
{
    public function testBuild()
    {
        $optionProduct = new OptionProduct;
        $optionProduct->setOption(new Option);
        $optionProduct->setProduct(new Product);

        $orderItemOptionProduct = new CartItemOptionProduct;
        $orderItemOptionProduct->setOptionProduct($optionProduct);
        $orderItemOptionProduct->setCartItem(new CartItem);

        $cartItemOptionProductDTO = $orderItemOptionProduct->getDTOBuilder()
            ->withAllData(new Pricing)
            ->build();

        $this->assertTrue($cartItemOptionProductDTO instanceof CartItemOptionProductDTO);
        $this->assertTrue($cartItemOptionProductDTO->optionProduct instanceof OptionProductDTO);
        $this->assertTrue($cartItemOptionProductDTO->optionProduct->option instanceof OptionDTO);
        $this->assertTrue($cartItemOptionProductDTO->optionProduct->product instanceof ProductDTO);
    }
}
