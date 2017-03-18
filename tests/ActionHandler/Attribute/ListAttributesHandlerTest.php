<?php
namespace inklabs\kommerce\ActionHandler\Attribute;

use inklabs\kommerce\Action\Attribute\ListAttributesQuery;
use inklabs\kommerce\ActionResponse\Attribute\ListAttributesResponse;
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
        $query = new ListAttributesQuery($queryString, new PaginationDTO());

        /** @var ListAttributesResponse $response */
        $response = $this->dispatchQuery($query);

        $this->assertEntitiesInDTOList([$attribute], $response->getAttributeDTOs());
        $this->assertTrue($response->getPaginationDTO() instanceof PaginationDTO);
    }
}
