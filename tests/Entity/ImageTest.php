<?php
namespace inklabs\kommerce\Entity;

use inklabs\kommerce\View;
use Symfony\Component\Validator\Validation;

class ImageTest extends \PHPUnit_Framework_TestCase
{
    public function testCreate()
    {
        $image = new Image;
        $image->setPath('http://lorempixel.com/400/200/');
        $image->setWidth(400);
        $image->setHeight(200);
        $image->setSortOrder(0);
        $image->setProduct(new Product);
        $image->setTag(new Tag);

        $validator = Validation::createValidatorBuilder()
            ->addMethodMapping('loadValidatorMetadata')
            ->getValidator();

        $this->assertEmpty($validator->validate($image));
        $this->assertSame('http://lorempixel.com/400/200/', $image->getPath());
        $this->assertSame(400, $image->getWidth());
        $this->assertSame(200, $image->getHeight());
        $this->assertSame(0, $image->getSortOrder());
        $this->assertTrue($image->getProduct() instanceof Product);
        $this->assertTrue($image->getTag() instanceof Tag);
        $this->assertTrue($image->getView() instanceof View\Image);
    }

    public function testLoadFromView()
    {
        $image = new Image;
        $image->loadFromView(new View\Image(new Image));
        $this->assertTrue($image instanceof Image);
    }
}
