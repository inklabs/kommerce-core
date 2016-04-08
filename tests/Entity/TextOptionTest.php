<?php
namespace inklabs\kommerce\Entity;

use inklabs\kommerce\tests\Helper\TestCase\EntityTestCase;

class TextOptionTest extends EntityTestCase
{
    public function testCreateDefaults()
    {
        $textOption = new TextOption;

        $this->assertSame(TextOption::TYPE_TEXT, $textOption->getType());
        $this->assertSame('Text', $textOption->getTypeText());
        $this->assertSame(null, $textOption->getName());
        $this->assertSame(null, $textOption->getDescription());
        $this->assertSame(0, $textOption->getSortOrder());
        $this->assertSame(0, count($textOption->getTags()));
    }

    public function testCreate()
    {
        $tag = $this->dummyData->getTag();

        $textOption = new TextOption;
        $textOption->setType(TextOption::TYPE_TEXTAREA);
        $textOption->setName('Custom Message');
        $textOption->setDescription('Custom engraved message');
        $textOption->setSortOrder(2);
        $textOption->addTag($tag);

        $this->assertEntityValid($textOption);
        $this->assertSame(TextOption::TYPE_TEXTAREA, $textOption->getType());
        $this->assertSame('Textarea', $textOption->getTypeText());
        $this->assertSame('Custom Message', $textOption->getName());
        $this->assertSame('Custom engraved message', $textOption->getDescription());
        $this->assertSame(2, $textOption->getSortOrder());
        $this->assertSame($tag, $textOption->getTags()[0]);
    }
}
