<?php
namespace inklabs\kommerce\EntityDTO;

use inklabs\kommerce\tests\Helper\DoctrineTestCase;

class ImageDTOBuilderTest extends DoctrineTestCase
{
    public function testBuild()
    {
        $image = $this->dummyData->getImage();
        $image->setProduct($this->dummyData->getProduct());
        $image->setTag($this->dummyData->getTag());

        $imageDTO = $image->getDTOBuilder()
            ->withAllData()
            ->build();

        $this->assertTrue($imageDTO instanceof ImageDTO);
        $this->assertTrue($imageDTO->product instanceof ProductDTO);
        $this->assertTrue($imageDTO->tag instanceof TagDTO);
    }
}
