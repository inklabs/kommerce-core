<?php
namespace inklabs\kommerce\EntityDTO;

use inklabs\kommerce\Entity\Product;
use inklabs\kommerce\Entity\ProductQuantityDiscount;
use inklabs\kommerce\Lib\Pricing;

class ProductQuantityDiscountDTOBuilderTest extends \PHPUnit_Framework_TestCase
{
    public function testBuild()
    {
        $productQuantityDiscount = new ProductQuantityDiscount;
        $productQuantityDiscount->setProduct(new Product);

        $productQuantityDiscountDTO = $productQuantityDiscount->getDTOBuilder()
            ->withAllData(new Pricing)
            ->build();

        $this->assertTrue($productQuantityDiscountDTO instanceof ProductQuantityDiscountDTO);
        $this->assertTrue($productQuantityDiscountDTO->price instanceof PriceDTO);
        $this->assertTrue($productQuantityDiscountDTO->product instanceof ProductDTO);
    }
}
