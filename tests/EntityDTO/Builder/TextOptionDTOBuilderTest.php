<?php
namespace inklabs\kommerce\EntityDTO;

use inklabs\kommerce\Entity\Tag;
use inklabs\kommerce\Entity\TextOption;

class TextOptionDTOBuilderTest extends \PHPUnit_Framework_TestCase
{
    public function testBuild()
    {
        $textOption = new TextOption;
        $textOption->addTag(new Tag);

        $textOptionDTO = $textOption->getDTOBuilder()
            ->withAllData()
            ->build();

        $this->assertTrue($textOptionDTO instanceof TextOptionDTO);
        $this->assertTrue($textOptionDTO->tags[0] instanceof TagDTO);
    }
}
