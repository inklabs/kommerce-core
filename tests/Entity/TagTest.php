<?php
namespace inklabs\kommerce\Entity;

use inklabs\kommerce\tests\Helper\TestCase\EntityTestCase;

class TagTest extends EntityTestCase
{
    public function testCreateDefaults()
    {
        $tag = new Tag;

        $this->assertSame(null, $tag->getName());
        $this->assertSame(null, $tag->getCode());
        $this->assertSame(null, $tag->getDescription());
        $this->assertSame(null, $tag->getDefaultImage());
        $this->assertSame(false, $tag->isActive());
        $this->assertSame(false, $tag->isVisible());
        $this->assertSame(0, $tag->getSortOrder());
        $this->assertSame(0, count($tag->getProducts()));
        $this->assertSame(0, count($tag->getImages()));
        $this->assertSame(0, count($tag->getOptions()));
        $this->assertSame(0, count($tag->getTextOptions()));
    }

    public function testCreate()
    {
        $product = $this->dummyData->getProduct();
        $option = $this->dummyData->getOption();
        $textOption = $this->dummyData->getTextOption();
        $image = $this->dummyData->getImage();
        $image->setPath('http://lorempixel.com/400/200/');

        $tag = new Tag;
        $tag->setName('Test Tag');
        $tag->setCode('TT');
        $tag->setDescription('Test Description');
        $tag->setDefaultImage(null);
        $tag->setSortOrder(0);
        $tag->setIsVisible(true);
        $tag->setIsActive(true);
        $tag->addProduct($product);
        $tag->addImage($image);
        $tag->addOption($option);
        $tag->addTextOption($textOption);

        $this->assertEntityValid($tag);
        $this->assertSame('Test Tag', $tag->getName());
        $this->assertSame('TT', $tag->getCode());
        $this->assertSame('Test Description', $tag->getDescription());
        $this->assertSame('http://lorempixel.com/400/200/', $tag->getDefaultImage());
        $this->assertSame(0, $tag->getSortOrder());
        $this->assertTrue($tag->isVisible());
        $this->assertTrue($tag->isActive());
        $this->assertSame($product, $tag->getProducts()[0]);
        $this->assertSame($image, $tag->getImages()[0]);
        $this->assertSame($option, $tag->getOptions()[0]);
        $this->assertSame($textOption, $tag->getTextOptions()[0]);
    }

    public function testStringOrNull()
    {
        $tag = new Tag;
        $tag->setCode('');
        $tag->setDescription('');
        $tag->setDefaultImage('');

        $this->assertSame(null, $tag->getCode());
        $this->assertSame(null, $tag->getDescription());
        $this->assertSame(null, $tag->getDefaultImage());
    }
}
