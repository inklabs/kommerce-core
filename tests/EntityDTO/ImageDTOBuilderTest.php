<?php
namespace inklabs\kommerce\EntityDTO;

use inklabs\kommerce\Entity\Image;
use inklabs\kommerce\Entity\Product;
use inklabs\kommerce\Entity\Tag;

class ImageDTOBuilderTest extends \PHPUnit_Framework_TestCase
{
    public function testCreate()
    {
        $image = new Image;
        $image->setProduct(new Product);
        $image->setTag(new Tag);

        $imageDTO = $image->getDTOBuilder()
            ->withAllData()
            ->build();

        $this->assertTrue($imageDTO instanceof ImageDTO);
        $this->assertTrue($imageDTO->product instanceof ProductDTO);
        $this->assertTrue($imageDTO->tag instanceof TagDTO);
    }
}
