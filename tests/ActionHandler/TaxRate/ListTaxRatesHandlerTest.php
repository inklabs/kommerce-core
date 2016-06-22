<?php
namespace inklabs\kommerce\ActionHandler\TaxRate;

use inklabs\kommerce\Action\TaxRate\ListTaxRatesQuery;
use inklabs\kommerce\Action\TaxRate\Query\ListTaxRatesRequest;
use inklabs\kommerce\Action\TaxRate\Query\ListTaxRatesResponse;
use inklabs\kommerce\EntityDTO\TaxRateDTO;
use inklabs\kommerce\tests\Helper\TestCase\ActionTestCase;

class ListTaxRatesHandlerTest extends ActionTestCase
{
    public function testHandle()
    {
        $taxRateService = $this->mockService->getTaxRateService();
        $dtoBuilderFactory = $this->getDTOBuilderFactory();

        $request = new ListTaxRatesRequest();
        $response = new ListTaxRatesResponse();

        $handler = new ListTaxRatesHandler($taxRateService, $dtoBuilderFactory);
        $handler->handle(new ListTaxRatesQuery($request, $response));

        $this->assertTrue($response->getTaxRateDTOs()[0] instanceof TaxRateDTO);
    }
}
