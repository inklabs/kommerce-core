<?php
namespace inklabs\kommerce\EntityDTO;

use inklabs\kommerce\tests\Helper\DoctrineTestCase;

class TagDTOBuilderTest extends DoctrineTestCase
{
    public function testBuild()
    {
        $tag = $this->dummyData->getTag();
        $tag->addImage($this->dummyData->getImage());
        $tag->addProduct($this->dummyData->getProductFull());
        $tag->addOption($this->dummyData->getOption());
        $tag->addTextOption($this->dummyData->getTextOption());

        $tagDTO = $tag->getDTOBuilder()
            ->withAllData($this->dummyData->getPricing())
            ->build();

        $this->assertTrue($tagDTO instanceof TagDTO);
        $this->assertTrue($tagDTO->images[0] instanceof ImageDTO);
        $this->assertTrue($tagDTO->options[0] instanceof OptionDTO);
        $this->assertTrue($tagDTO->textOptions[0] instanceof TextOptionDTO);

        $this->assertFullProductDTO($tagDTO->products[0]);
    }
}
