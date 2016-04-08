<?php
namespace inklabs\kommerce\EntityDTO;

use inklabs\kommerce\Entity\Image;
use inklabs\kommerce\Entity\Option;
use inklabs\kommerce\Entity\Tag;
use inklabs\kommerce\Entity\TextOption;
use inklabs\kommerce\tests\Helper;

class TagDTOBuilderTest extends Helper\DoctrineTestCase
{
    public function testBuild()
    {
        $tag = new Tag;
        $tag->addImage(new Image);
        $tag->addProduct($this->dummyData->getProductFull());
        $tag->addOption(new Option);
        $tag->addTextOption(new TextOption);

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
