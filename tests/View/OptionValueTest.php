<?php
namespace inklabs\kommerce\View;

use inklabs\kommerce\Entity;
use inklabs\kommerce\Service;

class OptionValueTest extends \PHPUnit_Framework_TestCase
{
    public function testCreate()
    {
        $optionValue = new Entity\OptionValue;
        $optionValue->setOption(new Entity\Option);

        $viewOptionValue = $optionValue->getView()
            ->withAllData()
            ->export();

        $this->assertTrue($viewOptionValue instanceof OptionValue);
        $this->assertTrue($viewOptionValue->option instanceof Option);
    }
}
