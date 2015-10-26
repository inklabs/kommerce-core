<?php
namespace inklabs\kommerce\Lib\ShipmentGateway;

use DateTime;
use EasyPost;
use inklabs\kommerce\Entity\Money;
use inklabs\kommerce\Entity\ShipmentLabel;
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

         $this->sortShipmentRatesLowestToHighest($shipmentRates);

        return $shipmentRates;
    }

    /**
     * @param string $shipmentExternalId
     * @param string $rateExternalId
     * @return ShipmentTracker
     */
    public function buy($shipmentExternalId, $rateExternalId)
    {
        $shipment = new EasyPost\Shipment($shipmentExternalId);
        $shipment->buy([
            'rate' => [
                'id' => $rateExternalId
            ]
        ]);

        return $this->getShipmentTrackerFromEasyPostShipment($shipment);
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
            'phone' => $address->phone,
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

    /**
     * @param ShipmentRate[] & $shipmentRates
     */
    protected function sortShipmentRatesLowestToHighest(& $shipmentRates)
    {
        usort(
            $shipmentRates,
            function (ShipmentRate $a, ShipmentRate $b) {
                return ($a->getRate()->getAmount() > $b->getRate()->getAmount());
            }
        );
    }

    private function getShipmentTrackerFromEasyPostShipment($shipment)
    {
        switch ($shipment->tracker->carrier) {
            case 'UPS':
                $carrier = ShipmentTracker::CARRIER_UPS;
                break;
            case 'USPS':
                $carrier = ShipmentTracker::CARRIER_USPS;
                break;
            case 'FEDEX':
                $carrier = ShipmentTracker::CARRIER_FEDEX;
                break;
            default:
                $carrier = ShipmentTracker::CARRIER_UNKNOWN;
        }

        $shipmentTracker = new ShipmentTracker($carrier, $shipment->tracking_code);
        $shipmentTracker->setExternalId($shipment->id);
        $shipmentTracker->setShipmentLabel($this->getShipmentLabelFromEasyPostShipment($shipment));
        $shipmentTracker->setShipmentRate($this->getShipmentRateFromEasyPostRate($shipment->selected_rate));
        return $shipmentTracker;
    }

    private function getShipmentLabelFromEasyPostShipment($shipment)
    {
        $label = $shipment->postage_label;

        $shipmentLabel = new ShipmentLabel;
        $shipmentLabel->setExternalId($label->id);
        $shipmentLabel->setResolution($label->label_resolution);
        $shipmentLabel->setSize($label->label_size);
        $shipmentLabel->setType($label->label_type);
        $shipmentLabel->setUrl($label->label_url);
        $shipmentLabel->setFileType($label->label_file_type);
        $shipmentLabel->setPdfUrl($label->label_pdf_url);
        $shipmentLabel->setEpl2Url($label->label_epl2_url);
        $shipmentLabel->setZplUrl($label->zpl_url);

        return $shipmentLabel;
    }
}
