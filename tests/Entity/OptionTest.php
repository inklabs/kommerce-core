<?php
namespace inklabs\kommerce\Entity;

class OptionTest extends \PHPUnit_Framework_TestCase
{
    public function testCreate()
    {
        $option = new Option;
        $option->setName('Size');
        $option->setType(Option::TYPE_RADIO);
        $option->setDescription('Shirt Size');
        $option->setSortOrder(0);
        $option->addOptionValue(new OptionValue(new Option));
        $option->addTag(new Tag);

        $this->assertSame('Size', $option->getname());
        $this->assertSame(Option::TYPE_RADIO, $option->getType());
        $this->assertSame('Radio', $option->getTypeText());
        $this->assertSame('Shirt Size', $option->getDescription());
        $this->assertSame(0, $option->getSortOrder());
        $this->assertTrue($option->getOptionValues()[0] instanceof OptionValue);
        $this->assertTrue($option->getTags()[0] instanceof Tag);
        $this->assertTrue($option->getView() instanceof View\Option);
    }
}
