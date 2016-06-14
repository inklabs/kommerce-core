<?php
namespace inklabs\kommerce\EntityDTO;

use inklabs\kommerce\tests\Helper\TestCase\EntityDTOBuilderTestCase;

class OptionDTOBuilderTest extends EntityDTOBuilderTestCase
{
    public function testBuild()
    {
        $option = $this->dummyData->getOption();
        $option->addTag($this->dummyData->getTag());
        $option->addOptionProduct($this->dummyData->getOptionProduct());
        $option->addOptionValue($this->dummyData->getOptionValue());

        $optionDTO = $this->getDTOBuilderFactory()
            ->getOptionDTOBuilder($option)
            ->withAllData($this->dummyData->getPricing())
            ->build();

        $this->assertTrue($optionDTO instanceof OptionDTO);
        $this->assertTrue($optionDTO->tags[0] instanceof TagDTO);
        $this->assertTrue($optionDTO->type instanceof OptionTypeDTO);
        $this->assertTrue($optionDTO->optionProducts[0] instanceof OptionProductDTO);
        $this->assertTrue($optionDTO->optionValues[0] instanceof OptionValueDTO);
    }
}
