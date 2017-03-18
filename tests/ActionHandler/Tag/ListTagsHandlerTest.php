<?php
namespace inklabs\kommerce\ActionHandler\Tag;

use inklabs\kommerce\Action\Tag\ListTagsQuery;
use inklabs\kommerce\Action\Tag\Query\ListTagsRequest;
use inklabs\kommerce\ActionResponse\Tag\ListTagsResponse;
use inklabs\kommerce\Entity\Tag;
use inklabs\kommerce\EntityDTO\PaginationDTO;
use inklabs\kommerce\tests\Helper\TestCase\ActionTestCase;

class ListTagsHandlerTest extends ActionTestCase
{
    protected $metaDataClassNames = [
        Tag::class,
    ];

    public function testHandle()
    {
        $tag = $this->dummyData->getTag();
        $this->persistEntityAndFlushClear($tag);
        $queryString = 'TT';
        $query = new ListTagsQuery($queryString, new PaginationDTO());

        /** @var ListTagsResponse $response */
        $response = $this->dispatchQuery($query);

        $this->assertEntitiesInDTOList([$tag], $response->getTagDTOs());
        $this->assertTrue($response->getPaginationDTO() instanceof PaginationDTO);
    }
}
