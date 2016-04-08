<?php
namespace inklabs\kommerce\EntityDTO;

use inklabs\kommerce\tests\Helper\DoctrineTestCase;

class ProductDTOBuilderTest extends DoctrineTestCase
{
    public function testBuild()
    {
        $product = $this->dummyData->getProductFull();

        $productDTO = $product->getDTOBuilder()
            ->withAllData($this->dummyData->getPricing())
            ->build();

        $this->assertFullProductDTO($productDTO);
    }
}
