<?php
namespace inklabs\kommerce\EntityDTO;

use inklabs\kommerce\tests\Helper\TestCase\EntityDTOBuilderTestCase;

class OptionProductDTOBuilderTest extends EntityDTOBuilderTestCase
{
    public function testBuild()
    {
        $optionProduct = $this->dummyData->getOptionProduct();

        $optionProductDTO = $this->getDTOBuilderFactory()
            ->getOptionProductDTOBuilder($optionProduct)
            ->withAllData($this->dummyData->getPricing())
            ->build();

        $this->assertTrue($optionProductDTO instanceof OptionProductDTO);
        $this->assertTrue($optionProductDTO->option instanceof OptionDTO);
        $this->assertTrue($optionProductDTO->product instanceof ProductDTO);
    }
}
