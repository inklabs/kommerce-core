<?php
namespace inklabs\kommerce\ActionHandler\TaxRate;

use inklabs\kommerce\Action\TaxRate\ListTaxRatesQuery;
use inklabs\kommerce\ActionResponse\TaxRate\ListTaxRatesResponse;
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
        $query = new ListTaxRatesQuery();

        /** @var ListTaxRatesResponse $response */
        $response = $this->dispatchQuery($query);

        $expectedEntities = [
            $taxRate,
        ];
        $this->assertEntitiesInDTOList($expectedEntities, $response->getTaxRateDTOs());
    }
}
