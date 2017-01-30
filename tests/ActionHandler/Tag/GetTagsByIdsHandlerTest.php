<?php
namespace inklabs\kommerce\ActionHandler\Tag;

use inklabs\kommerce\Action\Tag\GetTagsByIdsQuery;
use inklabs\kommerce\Action\Tag\Query\GetTagsByIdsRequest;
use inklabs\kommerce\Action\Tag\Query\GetTagsByIdsResponse;
use inklabs\kommerce\Entity\Tag;
use inklabs\kommerce\EntityDTO\TagDTO;
use inklabs\kommerce\tests\Helper\TestCase\ActionTestCase;

class GetTagsByIdsHandlerTest extends ActionTestCase
{
    protected $metaDataClassNames = [
        Tag::class,
    ];

    public function testHandle()
    {
        $tag = $this->dummyData->getTag();
        $this->persistEntityAndFlushClear($tag);
        $request = new GetTagsByIdsRequest([$tag->getId()->getHex()]);
        $response = new GetTagsByIdsResponse();
        $query = new GetTagsByIdsQuery($request, $response);

        $this->dispatchQuery($query);

        $this->assertTrue($response->getTagDTOs()[0] instanceof TagDTO);
    }
}
