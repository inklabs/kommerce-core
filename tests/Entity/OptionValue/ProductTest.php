<?php
namespace inklabs\kommerce\Entity\OptionValue;

use inklabs\kommerce\Entity;
use inklabs\kommerce\View;
use inklabs\kommerce\Service;

class ProductTest extends \PHPUnit_Framework_TestCase
{
    public function testCreate()
    {
        $product = new Entity\Product;
        $product->setSku('TST');
        $product->setname('Test Product');
        $product->setShippingWeight(16);

        $optionValueProduct = new Product($product);
        $optionValueProduct->setSortOrder(0);
        $optionValueProduct->setProduct($product);
        $optionValueProduct->setOptionType(new Entity\OptionType\Regular);

        $this->assertSame(0, $optionValueProduct->getSortOrder());
        $this->assertSame('TST', $optionValueProduct->getSku());
        $this->assertSame('Test Product', $optionValueProduct->getName());
        $this->assertSame(16, $optionValueProduct->getShippingWeight());
        $this->assertTrue($optionValueProduct->getPrice(new Service\Pricing) instanceof Entity\Price);
        $this->assertTrue($optionValueProduct->getOptionType() instanceof Entity\OptionType\Regular);
        $this->assertTrue($optionValueProduct->getProduct() instanceof Entity\Product);
        $this->assertTrue($optionValueProduct->getView() instanceof View\OptionValue\Product);
    }
}
