<?php
namespace inklabs\kommerce\ActionHandler\Option;

use inklabs\kommerce\Action\Option\ListOptionsQuery;
use inklabs\kommerce\Action\Option\Query\ListOptionsRequest;
use inklabs\kommerce\Action\Option\Query\ListOptionsResponse;
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
        $request = new ListOptionsRequest($queryString, new PaginationDTO());
        $response = new ListOptionsResponse();
        $query = new ListOptionsQuery($request, $response);

        $this->dispatchQuery($query);

        $this->assertEntityInDTOList($option, $response->getOptionDTOs());
        $this->assertTrue($response->getPaginationDTO() instanceof PaginationDTO);
    }
}
