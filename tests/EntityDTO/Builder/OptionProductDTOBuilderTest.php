<?php
namespace inklabs\kommerce\EntityDTO;

use inklabs\kommerce\tests\Helper\DoctrineTestCase;

class OptionProductDTOBuilderTest extends DoctrineTestCase
{
    public function testBuild()
    {
        $optionProduct = $this->dummyData->getOptionProduct();

        $optionProductDTO = $optionProduct->getDTOBuilder()
            ->withAllData($this->dummyData->getPricing())
            ->build();

        $this->assertTrue($optionProductDTO instanceof OptionProductDTO);
        $this->assertTrue($optionProductDTO->option instanceof OptionDTO);
        $this->assertTrue($optionProductDTO->product instanceof ProductDTO);
    }
}
