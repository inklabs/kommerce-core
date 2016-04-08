<?php
namespace inklabs\kommerce\EntityDTO;

use inklabs\kommerce\Entity\Option;
use inklabs\kommerce\Entity\OptionValue;

class OptionValueDTOBuilderTest extends \PHPUnit_Framework_TestCase
{
    public function testBuild()
    {
        $optionValue = new OptionValue;
        $optionValue->setOption(new Option);

        $optionValueDTO = $optionValue->getDTOBuilder()
            ->withAllData()
            ->build();

        $this->assertTrue($optionValueDTO instanceof OptionValueDTO);
        $this->assertTrue($optionValueDTO->option instanceof OptionDTO);
        $this->assertTrue($optionValueDTO->price instanceof PriceDTO);
    }
}
