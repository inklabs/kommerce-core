<?php
namespace inklabs\kommerce\EntityDTO;

use inklabs\kommerce\tests\Helper\TestCase\EntityDTOBuilderTestCase;

class ProductQuantityDiscountDTOBuilderTest extends EntityDTOBuilderTestCase
{
    public function testBuild()
    {
        $productQuantityDiscount = $this->dummyData->getProductQuantityDiscount();
        $productQuantityDiscount->setProduct($this->dummyData->getProduct());

        $productQuantityDiscountDTO = $productQuantityDiscount->getDTOBuilder()
            ->withAllData($this->dummyData->getPricing())
            ->build();

        $this->assertTrue($productQuantityDiscountDTO instanceof ProductQuantityDiscountDTO);
        $this->assertTrue($productQuantityDiscountDTO->price instanceof PriceDTO);
        $this->assertTrue($productQuantityDiscountDTO->product instanceof ProductDTO);
    }
}
