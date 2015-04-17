<?php
namespace inklabs\kommerce\Entity\OptionType;

use inklabs\kommerce\Entity\OptionValue;
use inklabs\kommerce\View;
use inklabs\kommerce\Entity;

class RegularTest extends \PHPUnit_Framework_TestCase
{
    public function testCreate()
    {
        $optionType = new Regular;
        $optionType->setType(Regular::TYPE_RADIO);
        $optionType->addOptionValue(new OptionValue\Product(new Entity\Product));

        $this->assertSame(Regular::TYPE_RADIO, $optionType->getType());
        $this->assertSame('Radio', $optionType->getTypeText());
        $this->assertTrue($optionType->getOptionValues()[0] instanceof OptionValue\Product);
        $this->assertTrue($optionType->getView() instanceof View\OptionType\Regular);
    }
}
