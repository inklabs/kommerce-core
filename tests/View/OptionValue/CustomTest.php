<?php
namespace inklabs\kommerce\View\OptionValue;

use inklabs\kommerce\Entity;
use inklabs\kommerce\View;
use inklabs\kommerce\Service;

class CustomTest extends \PHPUnit_Framework_TestCase
{
    public function testCreate()
    {
        $optionTypeCustom = new Entity\OptionType\Custom;
        $optionTypeCustom->addTag(new Entity\Tag);

        $optionValueCustom = new Entity\OptionValue\Custom;
        $optionValueCustom->setOptionType($optionTypeCustom);

        /** @var Custom $viewOptionValueCustom */
        $viewOptionValueCustom = $optionValueCustom->getView()
            ->withAllData(new Service\Pricing)
            ->export();

        $this->assertTrue($viewOptionValueCustom instanceof Custom);
        $this->assertTrue($viewOptionValueCustom->optionType instanceof View\OptionType\OptionTypeInterface);
    }
}
