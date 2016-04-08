<?php
namespace inklabs\kommerce\EntityDTO;

use inklabs\kommerce\tests\Helper\DoctrineTestCase;

class TextOptionDTOBuilderTest extends DoctrineTestCase
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
    }
}
