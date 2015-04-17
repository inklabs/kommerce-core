<?php
namespace inklabs\kommerce\Entity;

use inklabs\kommerce\View;
use Symfony\Component\Validator\Validation;

class TagTest extends \PHPUnit_Framework_TestCase
{
    public function testCreate()
    {
        $tag = new Tag;

        $tag->setDescription(null);
        $this->assertSame(null, $tag->getDescription());

        $tag->setName('Test Tag');
        $tag->setDescription('Test Description');
        $tag->setDefaultImage('http://lorempixel.com/400/200/');
        $tag->setSortOrder(0);
        $tag->setIsVisible(true);
        $tag->setIsActive(true);
        $tag->addProduct(new Product);
        $tag->addImage(new Image);
        $tag->addOptionType(new OptionType\Regular);

        $validator = Validation::createValidatorBuilder()
            ->addMethodMapping('loadValidatorMetadata')
            ->getValidator();

        $this->assertEmpty($validator->validate($tag));
        $this->assertSame('Test Tag', $tag->getName());
        $this->assertSame('Test Description', $tag->getDescription());
        $this->assertSame('http://lorempixel.com/400/200/', $tag->getDefaultImage());
        $this->assertSame(0, $tag->getSortOrder());
        $this->assertTrue($tag->isVisible());
        $this->assertTrue($tag->isActive());
        $this->assertTrue($tag->getProducts()[0] instanceof Product);
        $this->assertTrue($tag->getImages()[0] instanceof Image);
        $this->assertTrue($tag->getOptionTypes()[0] instanceof OptionType\AbstractOptionType);
        $this->assertTrue($tag->getView() instanceof View\Tag);
    }

    public function testLoadFromView()
    {
        $tag = new Tag;
        $tag->loadFromView(new View\Tag(new Tag));
        $this->assertTrue($tag instanceof Tag);
    }
}
