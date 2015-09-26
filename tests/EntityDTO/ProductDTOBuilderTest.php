<?php
namespace inklabs\kommerce\EntityDTO;

use inklabs\kommerce\tests\Helper;

class ProductDTOBuilderTest extends Helper\DoctrineTestCase
{
    public function testBuild()
    {
        $product = $this->getFullDummyProduct();

        $productDTO = $product->getDTOBuilder()
            ->withAllData($this->getFullDummyPricing())
            ->build();

        $this->assertFullProductDTO($productDTO);
    }
}
