<?php
namespace inklabs\kommerce\Entity;

use inklabs\kommerce\tests\Helper\DoctrineTestCase;

class OptionTest extends DoctrineTestCase
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

        $this->assertEntityValid($option);
        $this->assertSame(Option::TYPE_RADIO, $option->getType());
        $this->assertSame('Radio', $option->getTypeText());
        $this->assertTrue($option->getTags()[0] instanceof Tag);
        $this->assertTrue($option->getOptionProducts()[0] instanceof OptionProduct);
        $this->assertTrue($option->getOptionValues()[0] instanceof OptionValue);
    }
}
