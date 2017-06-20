<?php
namespace inklabs\kommerce\tests\Helper\Lib\ShipmentGateway;

use DateTime;
use inklabs\kommerce\Entity\ShipmentRate;
use inklabs\kommerce\Entity\ShipmentTracker;
use inklabs\kommerce\EntityDTO\OrderAddressDTO;
use inklabs\kommerce\EntityDTO\ParcelDTO;
use inklabs\kommerce\Lib\ShipmentGateway\ShipmentGatewayInterface;
use inklabs\kommerce\Lib\UuidInterface;
use inklabs\kommerce\tests\Helper\Entity\DummyData;

class FakeShipmentGateway implements ShipmentGatewayInterface
{
    /** @var OrderAddressDTO */
    private $fromAddress;

    public function __construct(OrderAddressDTO $fromAddress)
    {
        $this->fromAddress = $fromAddress;
    }

    /**
     * @param OrderAddressDTO $toAddress
     * @param ParcelDTO $parcel
     * @param null|OrderAddressDTO $fromAddress
     * @return ShipmentRate[]
     */
    public function getRates(OrderAddressDTO $toAddress, ParcelDTO $parcel, OrderAddressDTO $fromAddress = null): array
    {
        $dummyData = new DummyData;

        $shipmentExternalId = $this->getRandomShipmentExternalId();

        $shipmentRate1 = $dummyData->getShipmentRate(225);
        $shipmentRate1->setDeliveryDays(7);
        $shipmentRate1->setDeliveryDate(new DateTime('+7 days'));
        $shipmentRate1->setShipmentExternalId($shipmentExternalId);

        $shipmentRate2 = $dummyData->getShipmentRate(775);
        $shipmentRate2->setDeliveryDays(3);
        $shipmentRate2->setDeliveryDate(new DateTime('+3 days'));
        $shipmentRate2->setShipmentExternalId($shipmentExternalId);

        $shipmentRate3 = $dummyData->getShipmentRate(1195);
        $shipmentRate3->setDeliveryDays(2);
        $shipmentRate3->setDeliveryDate(new DateTime('+2 days'));
        $shipmentRate3->setIsDeliveryDateGuaranteed(true);
        $shipmentRate3->setShipmentExternalId($shipmentExternalId);

        return [
            $shipmentRate1,
            $shipmentRate2,
            $shipmentRate3,
        ];
    }

    /**
     * @param OrderAddressDTO $toAddress
     * @param ParcelDTO $parcel
     * @return ShipmentRate[]
     */
    public function getTrimmedRates(OrderAddressDTO $toAddress, ParcelDTO $parcel): array
    {
        return $this->getRates($toAddress, $parcel);
    }

    public function buy(string $shipmentExternalId, string $rateExternalId, UuidInterface $id = null): ShipmentTracker
    {
        $dummyData = new DummyData;
        $shipmentTracker = $dummyData->getShipmentTracker();
        $shipmentTracker->getShipmentLabel()->setExternalId($shipmentExternalId);
        $shipmentTracker->getShipmentRate()->setExternalId($rateExternalId);
        $shipmentTracker->setId($id);

        return $shipmentTracker;
    }

    public function getShipmentRateByExternalId(string $shipmentRateExternalId): ShipmentRate
    {
        $dummyData = new DummyData;

        $shipmentRate = $dummyData->getShipmentRate(225);
        $shipmentRate->setDeliveryDays(7);
        $shipmentRate->setShipmentExternalId($shipmentRateExternalId);
        return $shipmentRate;
    }

    protected function getRandomShipmentExternalId(): string
    {
        return 'shp_' . uniqid();
    }
}
