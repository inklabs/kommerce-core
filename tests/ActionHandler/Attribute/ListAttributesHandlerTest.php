<?php
namespace inklabs\kommerce\ActionHandler\Attribute;

use inklabs\kommerce\Action\Attribute\ListAttributesQuery;
use inklabs\kommerce\Action\Attribute\Query\ListAttributesRequest;
use inklabs\kommerce\Action\Attribute\Query\ListAttributesResponse;
use inklabs\kommerce\Entity\Attribute;
use inklabs\kommerce\EntityDTO\PaginationDTO;
use inklabs\kommerce\tests\Helper\TestCase\ActionTestCase;

class ListAttributesHandlerTest extends ActionTestCase
{
    protected $metaDataClassNames = [
        Attribute::class,
    ];

    public function testHandle()
    {
        $attribute = $this->dummyData->getAttribute();
        $attribute->setName('xxxPCTxxx');
        $this->persistEntityAndFlushClear($attribute);
        $queryString = 'PCT';
        $request = new ListAttributesRequest($queryString, new PaginationDTO());
        $response = new ListAttributesResponse();

        $this->dispatchQuery(new ListAttributesQuery($request, $response));

        $this->assertEntitiesInDTOList([$attribute], $response->getAttributeDTOs());
        $this->assertTrue($response->getPaginationDTO() instanceof PaginationDTO);
    }
}
