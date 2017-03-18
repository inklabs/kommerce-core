<?php
namespace inklabs\kommerce\ActionHandler\Option;

use inklabs\kommerce\Action\Option\ListOptionsQuery;
use inklabs\kommerce\ActionResponse\Option\ListOptionsResponse;
use inklabs\kommerce\Entity\Option;
use inklabs\kommerce\EntityDTO\PaginationDTO;
use inklabs\kommerce\tests\Helper\TestCase\ActionTestCase;

class ListOptionsHandlerTest extends ActionTestCase
{
    protected $metaDataClassNames = [
        Option::class,
    ];

    public function testHandle()
    {
        $option = $this->dummyData->getOption();
        $this->persistEntityAndFlushClear($option);
        $queryString = 'Size';
        $query = new ListOptionsQuery($queryString, new PaginationDTO());

        /** @var ListOptionsResponse $response */
        $response = $this->dispatchQuery($query);

        $this->assertEntityInDTOList($option, $response->getOptionDTOs());
        $this->assertTrue($response->getPaginationDTO() instanceof PaginationDTO);
    }
}
