<?php
namespace inklabs\kommerce\Lib\ShipmentGateway;

use DateTime;
use EasyPost;
use inklabs\kommerce\Entity\Money;
use inklabs\kommerce\Entity\ShipmentRate;
use inklabs\kommerce\Entity\ShipmentTracker;
use inklabs\kommerce\EntityDTO\OrderAddressDTO;
use inklabs\kommerce\EntityDTO\ParcelDTO;

class EasyPostGateway implements ShipmentGatewayInterface
{
    /** @var OrderAddressDTO */
    private $fromAddress;

    /**
     * @param string $apiKey
     * @param OrderAddressDTO $fromAddress
     */
    public function __construct($apiKey, OrderAddressDTO $fromAddress)
    {
        $this->fromAddress = $fromAddress;
        EasyPost\EasyPost::setApiKey($apiKey);
    }

    /**
     * @param OrderAddressDTO $toAddress
     * @param ParcelDTO $parcel
     * @return ShipmentRate[]
     */
    public function getRates(OrderAddressDTO $toAddress, ParcelDTO $parcel)
    {
        $shipment = EasyPost\Shipment::create([
            'from_address' => $this->getEasyPostAddress($this->fromAddress),
            'to_address' => $this->getEasyPostAddress($toAddress),
            'parcel' => $this->getEasyPostParcel($parcel),
        ]);

        $shipmentRates = [];
        foreach ($shipment->rates as $rate) {
            $shipmentRates[] = $this->getShipmentRateFromEasyPostRate($rate);
        }

        return $shipmentRates;
    }

    /**
     * @param string $shipmentExternalId
     * @param string $rateExternalId
     * @return ShipmentTracker
     */
    public function buy($shipmentExternalId, $rateExternalId)
    {
        // TODO: Implement buy() method.
    }

    /**
     * @param OrderAddressDTO $address
     * @return array
     */
    protected function getEasyPostAddress(OrderAddressDTO $address)
    {
        return [
            'name' => $address->fullName,
            'company' => $address->company,
            'street1' => $address->address1,
            'street2' => $address->address2,
            'city' => $address->city,
            'state' => $address->state,
            'zip' => $address->zip5,
            'country' => $address->country,
            'residential' => $address->isResidential
        ];
    }

    private function getEasyPostParcel(ParcelDTO $parcel)
    {
        return [
            'length' => $parcel->length,
            'width' => $parcel->width,
            'height' => $parcel->height,
            'weight' => $parcel->weight,
            'predefined_package' => $parcel->predefinedPackage,
        ];
    }

    private function getShipmentRateFromEasyPostRate($rate)
    {
        $shipmentRate = new ShipmentRate(new Money($rate->rate * 100, $rate->currency));
        $shipmentRate->setExternalId($rate->id);
        $shipmentRate->setShipmentExternalId($rate->shipment_id);
        $shipmentRate->setCarrier($rate->carrier);
        $shipmentRate->setService($rate->service);
        $shipmentRate->setIsDeliveryDateGuaranteed($rate->delivery_date_guaranteed);
        $shipmentRate->setListRate(new Money($rate->list_rate * 100, $rate->list_rate_currency));
        $shipmentRate->setRetailRate(new Money($rate->retail_rate * 100, $rate->retail_rate_currency));

        if (! empty($rate->delivery_date)) {
            $shipmentRate->setDeliveryDate(new DateTime($rate->delivery_date));
        }

        if (! empty($rate->delivery_days)) {
            $shipmentRate->setDeliveryDays($rate->delivery_days);
        }

        return $shipmentRate;
    }
}
