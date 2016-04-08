<?php
namespace inklabs\kommerce\EntityDTO;

use inklabs\kommerce\tests\Helper\TestCase\EntityDTOBuilderTestCase;

class OptionValueDTOBuilderTest extends EntityDTOBuilderTestCase
{
    public function testBuild()
    {
        $optionValue = $this->dummyData->getOptionValue();

        $optionValueDTO = $optionValue->getDTOBuilder()
            ->withAllData()
            ->build();

        $this->assertTrue($optionValueDTO instanceof OptionValueDTO);
        $this->assertTrue($optionValueDTO->option instanceof OptionDTO);
        $this->assertTrue($optionValueDTO->price instanceof PriceDTO);
    }
}
