<?php
namespace inklabs\kommerce\ActionHandler\TaxRate;

use inklabs\kommerce\Action\TaxRate\ListTaxRatesQuery;
use inklabs\kommerce\Action\TaxRate\Query\ListTaxRatesRequest;
use inklabs\kommerce\Action\TaxRate\Query\ListTaxRatesResponse;
use inklabs\kommerce\Entity\TaxRate;
use inklabs\kommerce\tests\Helper\TestCase\ActionTestCase;

class ListTaxRatesHandlerTest extends ActionTestCase
{
    protected $metaDataClassNames = [
        TaxRate::class,
    ];

    public function testHandle()
    {
        $taxRate = $this->dummyData->getStateTaxRate();
        $this->persistEntityAndFlushClear($taxRate);
        $request = new ListTaxRatesRequest();
        $response = new ListTaxRatesResponse();
        $query = new ListTaxRatesQuery($request, $response);

        $this->dispatchQuery($query);

        $expectedEntities = [
            $taxRate,
        ];
        $this->assertEntitiesInDTOList($expectedEntities, $response->getTaxRateDTOs());
    }
}
