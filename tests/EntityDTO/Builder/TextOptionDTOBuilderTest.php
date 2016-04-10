<?php
namespace inklabs\kommerce\EntityDTO;

use inklabs\kommerce\tests\Helper\TestCase\EntityDTOBuilderTestCase;

class TextOptionDTOBuilderTest extends EntityDTOBuilderTestCase
{
    public function testBuild()
    {
        $textOption = $this->dummyData->getTextOption();
        $textOption->addTag($this->dummyData->getTag());

        $textOptionDTO = $textOption->getDTOBuilder()
            ->withAllData()
            ->build();

        $this->assertTrue($textOptionDTO instanceof TextOptionDTO);
        $this->assertTrue($textOptionDTO->tags[0] instanceof TagDTO);
        $this->assertTrue($textOptionDTO->type instanceof TextOptionTypeDTO);
    }
}
