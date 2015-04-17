<?php
namespace inklabs\kommerce\Entity\OptionType;

use inklabs\kommerce\Entity\OptionValue;
use inklabs\kommerce\View;

class CustomTest extends \PHPUnit_Framework_TestCase
{
    public function testCreate()
    {
        $optionType = new Custom;
        $optionType->setType(Custom::TYPE_TEXT);
        $optionType->addOptionValue(new OptionValue\Custom);

        $this->assertSame(Custom::TYPE_TEXT, $optionType->getType());
        $this->assertSame('Text', $optionType->getTypeText());
        $this->assertTrue($optionType->getOptionValues()[0] instanceof OptionValue\Custom);
        $this->assertTrue($optionType->getView() instanceof View\OptionType\Custom);
    }
}
