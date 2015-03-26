<?php
namespace inklabs\kommerce\Entity\View;

use inklabs\kommerce\Entity as Entity;
use inklabs\kommerce\Service as Service;

class OptionValueTest extends \PHPUnit_Framework_TestCase
{
    public function testCreate()
    {
        $entityOptionValue = new Entity\OptionValue;
        $entityOptionValue->setProduct(new Entity\Product);

        $optionValue = $entityOptionValue->getView()
            ->withAllData(new Service\Pricing)
            ->export();

        $this->assertTrue($optionValue instanceof OptionValue);
        $this->assertTrue($optionValue->product instanceof Product);
    }
}
