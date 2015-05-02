<?php
namespace inklabs\kommerce\View;

use inklabs\kommerce\Entity;
use inklabs\kommerce\Lib;

class OptionTest extends \PHPUnit_Framework_TestCase
{
    public function testCreate()
    {
        $optionProduct = new Entity\OptionProduct;
        $optionProduct->setProduct(new Entity\Product);

        $textOption = new Entity\Option;
        $textOption->addTag(new Entity\Tag);
        $textOption->addOptionProduct($optionProduct);
        $textOption->addOptionValue(new Entity\OptionValue);

        $viewOption = $textOption->getView()
            ->withAllData(new Lib\Pricing)
            ->export();

        $this->assertTrue($viewOption instanceof Option);
        $this->assertTrue($viewOption->tags[0] instanceof Tag);
        $this->assertTrue($viewOption->optionProducts[0] instanceof OptionProduct);
        $this->assertTrue($viewOption->optionValues[0] instanceof OptionValue);
    }
}
