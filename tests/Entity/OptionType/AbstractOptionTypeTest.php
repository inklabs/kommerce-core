<?php
namespace inklabs\kommerce\Entity\OptionType;

use inklabs\kommerce\Entity;

class AbstractOptionTypeTest extends \PHPUnit_Framework_TestCase
{
    public function testCreate()
    {
        /** @var AbstractOptionType $option */
        $option = \Mockery::mock('inklabs\kommerce\Entity\OptionType\AbstractOptionType')->makePartial();
        $option->setName('Size');
        $option->setDescription('Shirt Size');
        $option->setSortOrder(0);
        $option->setType(1);
        $option->addTag(new Entity\Tag);

        $this->assertSame('Size', $option->getName());
        $this->assertSame(1, $option->getType());
        $this->assertSame('Shirt Size', $option->getDescription());
        $this->assertSame(0, $option->getSortOrder());
        $this->assertTrue($option->getTags()[0] instanceof Entity\Tag);
    }
}
