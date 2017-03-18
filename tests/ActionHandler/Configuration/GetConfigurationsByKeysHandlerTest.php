<?php
namespace inklabs\kommerce\ActionHandler\Configuration;

use inklabs\kommerce\Action\Configuration\GetConfigurationsByKeysQuery;
use inklabs\kommerce\ActionResponse\Configuration\GetConfigurationsByKeysResponse;
use inklabs\kommerce\Entity\Configuration;
use inklabs\kommerce\tests\Helper\TestCase\ActionTestCase;

class GetConfigurationsByKeysHandlerTest extends ActionTestCase
{
    protected $metaDataClassNames = [
        Configuration::class,
    ];

    public function testHandle()
    {
        $configuration1 = $this->dummyData->getConfiguration('adminTheme');
        $configuration2 = $this->dummyData->getConfiguration('storeTheme');
        $configuration3 = $this->dummyData->getConfiguration('stripeApiKey');
        $this->persistEntityAndFlushClear([
            $configuration1,
            $configuration2,
            $configuration3
        ]);
        $query = new GetConfigurationsByKeysQuery([
            'adminTheme',
            'storeTheme',
        ]);

        /** @var GetConfigurationsByKeysResponse $response */
        $response = $this->dispatchQuery($query);

        $configurations = $response->getConfigurationDTOs();
        $this->assertCount(2, $configurations);
        $this->assertSame($configuration1->getkey(), $configurations[0]->key);
        $this->assertSame($configuration2->getkey(), $configurations[1]->key);
    }
}
