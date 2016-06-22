<?php
namespace inklabs\kommerce\ActionHandler\Option;

use inklabs\kommerce\Action\Option\ListOptionsQuery;
use inklabs\kommerce\Action\Option\Query\ListOptionsRequest;
use inklabs\kommerce\Action\Option\Query\ListOptionsResponse;
use inklabs\kommerce\EntityDTO\PaginationDTO;
use inklabs\kommerce\EntityDTO\OptionDTO;
use inklabs\kommerce\tests\Helper\TestCase\ActionTestCase;

class ListOptionsHandlerTest extends ActionTestCase
{
    public function testHandle()
    {
        $optionService = $this->mockService->getOptionService();
        $dtoBuilderFactory = $this->getDTOBuilderFactory();

        $queryString = 'TT';
        $request = new ListOptionsRequest($queryString, new PaginationDTO);
        $response = new ListOptionsResponse();

        $handler = new ListOptionsHandler($optionService, $dtoBuilderFactory);
        $handler->handle(new ListOptionsQuery($request, $response));

        $this->assertTrue($response->getOptionDTOs()[0] instanceof OptionDTO);
        $this->assertTrue($response->getPaginationDTO() instanceof PaginationDTO);
    }
}
