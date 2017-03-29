<?php
namespace inklabs\kommerce\EntityDTO;

use inklabs\kommerce\tests\Helper\TestCase\EntityDTOBuilderTestCase;

class ImageDTOBuilderTest extends EntityDTOBuilderTestCase
{
    public function testBuild()
    {
        $image = $this->dummyData->getImage();
        $image->setProduct($this->dummyData->getProduct());
        $image->setTag($this->dummyData->getTag());

        $imageDTO = $this->getDTOBuilderFactory()
            ->getImageDTOBuilder($image)
            ->withAllData()
            ->build();

        $this->assertTrue($imageDTO instanceof ImageDTO);
        $this->assertTrue($imageDTO->product instanceof ProductDTO);
        $this->assertTrue($imageDTO->tag instanceof TagDTO);
    }
}
