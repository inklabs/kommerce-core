<?php
namespace inklabs\kommerce\Entity;

use inklabs\kommerce\tests\Helper\TestCase\EntityTestCase;

class TextOptionTest extends EntityTestCase
{
    public function testCreateDefaults()
    {
        $textOption = new TextOption;

        $this->assertSame(null, $textOption->getName());
        $this->assertSame(null, $textOption->getDescription());
        $this->assertSame(0, $textOption->getSortOrder());
        $this->assertSame(0, count($textOption->getTags()));
        $this->assertTrue($textOption->getType()->isText());
    }

    public function testCreate()
    {
        $textOptionType = $this->dummyData->getTextOptionType();
        $tag = $this->dummyData->getTag();

        $textOption = new TextOption;
        $textOption->setType($textOptionType);
        $textOption->setName('Custom Message');
        $textOption->setDescription('Custom engraved message');
        $textOption->setSortOrder(2);
        $textOption->addTag($tag);

        $this->assertEntityValid($textOption);
        $this->assertSame($textOptionType, $textOption->getType());
        $this->assertSame('Custom Message', $textOption->getName());
        $this->assertSame('Custom engraved message', $textOption->getDescription());
        $this->assertSame(2, $textOption->getSortOrder());
        $this->assertSame($tag, $textOption->getTags()[0]);
    }
}
