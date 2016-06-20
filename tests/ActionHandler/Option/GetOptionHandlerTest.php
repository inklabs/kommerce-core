<?php
namespace inklabs\kommerce\ActionHandler\Option;

use inklabs\kommerce\Action\Option\GetOptionQuery;
use inklabs\kommerce\Action\Option\Query\GetOptionRequest;
use inklabs\kommerce\Action\Option\Query\GetOptionResponse;
use inklabs\kommerce\EntityDTO\OptionDTO;
use inklabs\kommerce\tests\Helper\TestCase\ActionTestCase;

class GetOptionHandlerTest extends ActionTestCase
{
    public function testHandle()
    {
        $pricing = $this->dummyData->getPricing();
        $userService = $this->mockService->getOptionService();
        $dtoBuilderFactory = $this->getDTOBuilderFactory();

        $request = new GetOptionRequest(self::UUID_HEX);
        $response = new GetOptionResponse($pricing);

        $handler = new GetOptionHandler($userService, $dtoBuilderFactory);

        $handler->handle(new GetOptionQuery($request, $response));
        $this->assertTrue($response->getOptionDTO() instanceof OptionDTO);

        $handler->handle(new GetOptionQuery($request, $response));
        $this->assertTrue($response->getOptionDTOWithAllData() instanceof OptionDTO);
    }
}
