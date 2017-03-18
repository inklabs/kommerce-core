<?php
namespace inklabs\kommerce\ActionHandler\Tag;

use inklabs\kommerce\Action\Tag\GetTagQuery;
use inklabs\kommerce\ActionResponse\Tag\GetTagResponse;
use inklabs\kommerce\Entity\Image;
use inklabs\kommerce\Entity\Option;
use inklabs\kommerce\Entity\Product;
use inklabs\kommerce\Entity\Tag;
use inklabs\kommerce\Entity\TextOption;
use inklabs\kommerce\tests\Helper\TestCase\ActionTestCase;

class GetTagHandlerTest extends ActionTestCase
{
    protected $metaDataClassNames = [
        Image::class,
        Option::class,
        Product::class,
        Tag::class,
        TextOption::class,
    ];

    public function testHandle()
    {
        $tag = $this->dummyData->getTag();
        $this->persistEntityAndFlushClear($tag);
        $pricing = $this->dummyData->getPricing();
        $query = new GetTagQuery($tag->getId()->getHex());

        /** @var GetTagResponse $response */
        $response = $this->dispatchQuery($query);
        $this->assertSame($tag->getId()->getHex(), $response->getTagDTO()->id->getHex());

        $response = $this->dispatchQuery($query);
        $this->assertSame($tag->getId()->getHex(), $response->getTagDTOWithAllData()->id->getHex());
    }
}
