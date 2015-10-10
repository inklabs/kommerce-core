<?php
namespace inklabs\kommerce\Entity;

use Symfony\Component\Validator\Validation;

class OptionTest extends \PHPUnit_Framework_TestCase
{
    public function testCreate()
    {
        $option = new Option;
        $option->setType(Option::TYPE_RADIO);
        $option->setName('Size');
        $option->setDescription('Shirt Size');
        $option->setSortOrder(0);
        $option->addTag(new Tag);
        $option->addOptionProduct(new OptionProduct(new Product));
        $option->addOptionValue(new OptionValue);

        $validator = Validation::createValidatorBuilder()
            ->addMethodMapping('loadValidatorMetadata')
            ->getValidator();

        $this->assertEmpty($validator->validate($option));
        $this->assertSame(Option::TYPE_RADIO, $option->getType());
        $this->assertSame('Radio', $option->getTypeText());
        $this->assertTrue($option->getTags()[0] instanceof Tag);
        $this->assertTrue($option->getOptionProducts()[0] instanceof OptionProduct);
        $this->assertTrue($option->getOptionValues()[0] instanceof OptionValue);
    }
}
