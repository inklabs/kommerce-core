<?php
namespace inklabs\kommerce\Entity;

use inklabs\kommerce\Lib\Pricing;
use Symfony\Component\Validator\Validation;

class OptionProductTest extends \PHPUnit_Framework_TestCase
{
    public function testCreate()
    {
        $option = new Option;
        $option->setType(Option::TYPE_SELECT);
        $option->setName('Size');
        $option->setDescription('Shirt Size');

        $product = new Product;
        $product->setSku('SM');
        $product->setName('Small Shirt');
        $product->setShippingWeight(16);

        $optionProduct = new OptionProduct($product);
        $optionProduct->setSortOrder(0);
        $optionProduct->setProduct($product);
        $optionProduct->setOption($option);

        $validator = Validation::createValidatorBuilder()
            ->addMethodMapping('loadValidatorMetadata')
            ->getValidator();

        $this->assertEmpty($validator->validate($optionProduct));
        $this->assertSame(0, $optionProduct->getSortOrder());
        $this->assertSame('SM', $optionProduct->getSku());
        $this->assertSame('Small Shirt', $optionProduct->getName());
        $this->assertSame(16, $optionProduct->getShippingWeight());
        $this->assertTrue($optionProduct->getPrice(new Pricing) instanceof Price);
        $this->assertTrue($optionProduct->getOption() instanceof Option);
        $this->assertTrue($optionProduct->getProduct() instanceof Product);
    }
}
