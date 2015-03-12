<?php
namespace inklabs\kommerce\Entity;

use Symfony\Component\Validator\Validation;

class TagTest extends \PHPUnit_Framework_TestCase
{
    public function testCreate()
    {
        $tag = new Tag;

        $tag->setDescription(null);
        $this->assertSame(null, $tag->getDescription());

        $tag->setId(1);
        $tag->setName('Test Tag');
        $tag->setDescription('Test Description');
        $tag->setDefaultImage('http://lorempixel.com/400/200/');
        $tag->setSortOrder(0);
        $tag->setIsVisible(true);
        $tag->setIsActive(true);
        $tag->addProduct(new Product);
        $tag->addImage(new Image);

        $validator = Validation::createValidatorBuilder()
            ->addMethodMapping('loadValidatorMetadata')
            ->getValidator();

        $this->assertEmpty($validator->validate($tag));
        $this->assertSame(1, $tag->getId());
        $this->assertSame('Test Tag', $tag->getName());
        $this->assertSame('Test Description', $tag->getDescription());
        $this->assertSame('http://lorempixel.com/400/200/', $tag->getDefaultImage());
        $this->assertSame(0, $tag->getSortOrder());
        $this->assertTrue($tag->getIsVisible());
        $this->assertTrue($tag->getIsActive());
        $this->assertTrue($tag->getProducts()[0] instanceof Product);
        $this->assertTrue($tag->getImages()[0] instanceof Image);
        $this->assertTrue($tag->getView() instanceof View\Tag);
    }

    public function testLoadFromView()
    {
        $tag = new Tag;
        $tag->loadFromView(new View\Tag(new Tag));
        $this->assertTrue($tag instanceof Tag);
    }
}
