<?php
namespace inklabs\kommerce\EntityDTO;

use inklabs\kommerce\Entity\Option;
use inklabs\kommerce\Entity\OptionProduct;
use inklabs\kommerce\Entity\Product;
use inklabs\kommerce\Lib\Pricing;

class OptionProductDTOBuilderTest extends \PHPUnit_Framework_TestCase
{
    public function testBuild()
    {
        $optionProduct = new OptionProduct;
        $optionProduct->setOption(new Option);
        $optionProduct->setProduct(new Product);

        $optionProductDTO = $optionProduct->getDTOBuilder()
            ->withAllData(new Pricing)
            ->build();

        $this->assertTrue($optionProductDTO instanceof OptionProductDTO);
        $this->assertTrue($optionProductDTO->option instanceof OptionDTO);
        $this->assertTrue($optionProductDTO->product instanceof ProductDTO);
    }
}
