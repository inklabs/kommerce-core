<?php
namespace inklabs\kommerce\EntityDTO;

use inklabs\kommerce\Entity\Option;
use inklabs\kommerce\Entity\OptionProduct;
use inklabs\kommerce\Entity\OptionValue;
use inklabs\kommerce\Entity\Product;
use inklabs\kommerce\Entity\Tag;
use inklabs\kommerce\Lib\Pricing;

class OptionDTOBuilderTest extends \PHPUnit_Framework_TestCase
{
    public function testBuild()
    {
        $optionProduct = new OptionProduct;
        $optionProduct->setProduct(new Product);

        $option = new Option;
        $option->addTag(new Tag);
        $option->addOptionProduct($optionProduct);
        $option->addOptionValue(new OptionValue);

        $optionDTO = $option->getDTOBuilder()
            ->withAllData(new Pricing)
            ->build();

        $this->assertTrue($optionDTO instanceof OptionDTO);
        $this->assertTrue($optionDTO->tags[0] instanceof TagDTO);
        $this->assertTrue($optionDTO->optionProducts[0] instanceof OptionProductDTO);
        $this->assertTrue($optionDTO->optionValues[0] instanceof OptionValueDTO);
    }
}
