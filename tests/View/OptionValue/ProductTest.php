<?php
namespace inklabs\kommerce\View\OptionValue;

use inklabs\kommerce\Entity;
use inklabs\kommerce\View;
use inklabs\kommerce\Service;

class ProductTest extends \PHPUnit_Framework_TestCase
{
    public function testCreate()
    {
        $optionTypeProduct = new Entity\OptionType\Regular;
        $optionTypeProduct->addTag(new Entity\Tag);

        $optionValueProduct = new Entity\OptionValue\Product(new Entity\Product);
        $optionValueProduct->setOptionType($optionTypeProduct);

        /** @var Product $viewOptionValueProduct */
        $viewOptionValueProduct = $optionValueProduct->getView()
            ->withAllData(new Service\Pricing)
            ->export();

        $this->assertTrue($viewOptionValueProduct instanceof Product);
        $this->assertTrue($viewOptionValueProduct->optionType instanceof View\OptionType\OptionTypeInterface);
        $this->assertTrue($viewOptionValueProduct->product instanceof View\Product);
    }
}
