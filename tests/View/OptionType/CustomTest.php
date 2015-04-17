<?php
namespace inklabs\kommerce\View\OptionType;

use inklabs\kommerce\Entity;
use inklabs\kommerce\View;
use inklabs\kommerce\Service;

class CustomTest extends \PHPUnit_Framework_TestCase
{
    public function testCreate()
    {
        $optionTypeCustom = new Entity\OptionType\Regular;
        $optionTypeCustom->addTag(new Entity\Tag);
        $optionTypeCustom->addOptionValue(new Entity\OptionValue\Custom);

        $viewOptionTypeCustom = $optionTypeCustom->getView()
            ->withAllData(new Service\Pricing)
            ->export();

        $this->assertTrue($viewOptionTypeCustom instanceof Regular);
        $this->assertTrue($viewOptionTypeCustom->optionValues[0] instanceof View\OptionValue\Custom);
        $this->assertTrue($viewOptionTypeCustom->tags[0] instanceof View\Tag);
    }
}
