<?php
namespace inklabs\kommerce\ActionHandler\Warehouse;

use inklabs\kommerce\Action\Warehouse\CreateWarehouseCommand;
use inklabs\kommerce\Entity\Warehouse;
use inklabs\kommerce\tests\Helper\TestCase\ActionTestCase;

class CreateWarehouseHandlerTest extends ActionTestCase
{
    protected $metaDataClassNames = [
        Warehouse::class,
    ];

    public function testHandle()
    {
        $name = 'Warehouse Name';
        $attention = 'Attention';
        $company = 'Company';
        $address1 = 'Address1';
        $address2 = 'Address2';
        $city = 'Santa Monica';
        $state = 'CA';
        $zip5 = '90210';
        $zip4 = '6808';
        $latitude = '34.052234';
        $longitude = '-118.243685';
        $command = new CreateWarehouseCommand(
            $name,
            $attention,
            $company,
            $address1,
            $address2,
            $city,
            $state,
            $zip5,
            $zip4,
            $latitude,
            $longitude
        );

        $this->dispatchCommand($command);

        $this->entityManager->clear();
        $warehouse = $this->getRepositoryFactory()->getWarehouseRepository()->findOneById(
            $command->getWarehouseId()
        );
        $this->assertSame($name, $warehouse->getName());
        $address = $warehouse->getAddress();
        $this->assertSame($attention, $address->getAttention());
        $this->assertSame($company, $address->getCompany());
        $this->assertSame($address1, $address->getAddress1());
        $this->assertSame($address2, $address->getAddress2());
        $this->assertSame($city, $address->getCity());
        $this->assertSame($state, $address->getstate());
        $this->assertSame($zip5, $address->getzip5());
        $this->assertSame($zip4, $address->getzip4());
        $point = $address->getPoint();
        $this->assertSame($latitude, $point->getlatitude());
        $this->assertSame($longitude, $point->getlongitude());
    }
}
