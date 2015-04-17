<?php
namespace inklabs\kommerce\Entity\OptionValue;

use inklabs\kommerce\Entity;
use inklabs\kommerce\View;
use inklabs\kommerce\Service;

class CustomTest extends \PHPUnit_Framework_TestCase
{
    public function testCreate()
    {
        $optionTypeCustom = new Entity\OptionType\Custom;
        $optionValueCustom = new Custom($optionTypeCustom);

        $optionValueCustom->setSortOrder(0);
        $optionValueCustom->setSku('TST');
        $optionValueCustom->setName('Test Name');
        $optionValueCustom->setShippingWeight(16);
        $optionValueCustom->setOptionType($optionTypeCustom);
        $optionValueCustom->setPrice(new Entity\Price);

        $this->assertSame(0, $optionValueCustom->getSortOrder());
        $this->assertSame('TST', $optionValueCustom->getSku());
        $this->assertSame('Test Name', $optionValueCustom->getName());
        $this->assertSame(16, $optionValueCustom->getShippingWeight());
        $this->assertTrue($optionValueCustom->getOptionType() instanceof Entity\OptionType\Custom);
        $this->assertTrue($optionValueCustom->getPrice(new Service\Pricing) instanceof Entity\Price);
        $this->assertTrue($optionValueCustom->getView() instanceof View\OptionValue\Custom);
    }
}
