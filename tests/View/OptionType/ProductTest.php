<?php
namespace inklabs\kommerce\View\OptionType;

use inklabs\kommerce\View;
use inklabs\kommerce\Entity;
use inklabs\kommerce\Service;

class ProductTest extends \PHPUnit_Framework_TestCase
{
    public function testCreate()
    {
        $optionTypeProduct = new Entity\OptionType\Regular;
        $optionTypeProduct->addTag(new Entity\Tag);
        $optionTypeProduct->addOptionValue(new Entity\OptionValue\Product(new Entity\Product));

        $viewOptionTypeProduct = $optionTypeProduct->getView()
            ->withAllData(new Service\Pricing)
            ->export();

        $this->assertTrue($viewOptionTypeProduct instanceof Regular);
        $this->assertTrue($viewOptionTypeProduct->optionValues[0] instanceof View\OptionValue\Product);
        $this->assertTrue($viewOptionTypeProduct->tags[0] instanceof View\Tag);
    }
}
