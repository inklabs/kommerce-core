<?php
namespace inklabs\kommerce\Entity;

use DateTime;
use inklabs\kommerce\EntityDTO\Builder\ShipmentRateDTOBuilder;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;

class ShipmentRate implements ValidationInterface
{
    /** @var string */
    protected $externalId;

    /** @var string */
    protected $shipmentExternalId;

    /** @var string */
    protected $service;

    /** @var string */
    protected $carrier;

    /** @var int */
    protected $deliveryDate;

    /** @var boolean */
    protected $isDeliveryDateGuaranteed;

    /** @var int */
    protected $deliveryDays;

    /** @var int */
    protected $estDeliveryDays;

    /** @var int */
    protected $deliveryMethod;
    const DELIVERY_METHOD_STANDARD = 0;
    const DELIVERY_METHOD_ONE_DAY = 1;
    const DELIVERY_METHOD_TWO_DAY = 2;

    /** @var Money */
    protected $rate;

    /** @var Money */
    protected $listRate;

    /** @var Money */
    protected $retailRate;

    public function __construct(Money $rate)
    {
        $this->rate = $rate;
        $this->isDeliveryDateGuaranteed = false;
        $this->setDeliveryMethod();
    }

    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraint('rate', new Assert\Valid);
        $metadata->addPropertyConstraint('listRate', new Assert\Valid);
        $metadata->addPropertyConstraint('retailRate', new Assert\Valid);

        $metadata->addPropertyConstraint('externalId', new Assert\Length([
            'max' => 60,
        ]));

        $metadata->addPropertyConstraint('shipmentExternalId', new Assert\Length([
            'max' => 60,
        ]));

        $metadata->addPropertyConstraint('service', new Assert\Length([
            'max' => 20,
        ]));

        $metadata->addPropertyConstraint('carrier', new Assert\Length([
            'max' => 20,
        ]));

        $metadata->addPropertyConstraint('deliveryDays', new Assert\Range([
            'min' => 0,
            'max' => 65535,
        ]));

        $metadata->addPropertyConstraint('estDeliveryDays', new Assert\Range([
            'min' => 0,
            'max' => 65535,
        ]));
    }

    public function getRate()
    {
        return $this->rate;
    }

    /**
     * @param string $service
     */
    public function setService($service)
    {
        $this->service = (string) $service;
    }

    public function getService()
    {
        return $this->service;
    }

    /**
     * @param string $carrier
     */
    public function setCarrier($carrier)
    {
        $this->carrier = (string) $carrier;
    }

    public function getCarrier()
    {
        return $this->carrier;
    }

    /**
     * @param string $externalId
     */
    public function setExternalId($externalId)
    {
        $this->externalId = (string) $externalId;
    }

    public function getExternalId()
    {
        return $this->externalId;
    }

    /**
     * @param string $shipmentExternalId
     */
    public function setShipmentExternalId($shipmentExternalId)
    {
        $this->shipmentExternalId = (string) $shipmentExternalId;
    }

    public function getShipmentExternalId()
    {
        return $this->shipmentExternalId;
    }

    /**
     * @param DateTime $deliveryDate
     */
    public function setDeliveryDate(DateTime $deliveryDate = null)
    {
        $this->deliveryDate = $deliveryDate->gettimestamp();
    }

    /**
     * @return DateTime|null
     */
    public function getDeliveryDate()
    {
        if ($this->deliveryDate === null) {
            return null;
        }

        $deliveryDate = new DateTime();
        $deliveryDate->setTimestamp($this->deliveryDate);
        return $deliveryDate;
    }

    /**
     * @param boolean $isDeliveryDateGuaranteed
     */
    public function setIsDeliveryDateGuaranteed($isDeliveryDateGuaranteed)
    {
        $this->isDeliveryDateGuaranteed = (bool) $isDeliveryDateGuaranteed;
    }

    public function isDeliveryDateGuaranteed()
    {
        return $this->isDeliveryDateGuaranteed;
    }

    /**
     * @param int $deliveryDays
     */
    public function setDeliveryDays($deliveryDays)
    {
        $this->deliveryDays = (int) $deliveryDays;

        $this->setDeliveryMethod();
    }

    /**
     * @param int $estDeliveryDays
     */
    public function setEstDeliveryDays($estDeliveryDays = null)
    {
        if ($estDeliveryDays !== null) {
            $estDeliveryDays = (int) $estDeliveryDays;
        }

        $this->estDeliveryDays = $estDeliveryDays;
    }

    public function getDeliveryDays()
    {
        return $this->deliveryDays;
    }

    public function getEstDeliveryDays()
    {
        return $this->estDeliveryDays;
    }

    public function setListRate(Money $listRate)
    {
        $this->listRate = $listRate;
    }

    public function setRetailRate(Money $retailRate)
    {
        $this->retailRate = $retailRate;
    }

    public function getListRate()
    {
        return $this->listRate;
    }

    public function getRetailRate()
    {
        return $this->retailRate;
    }

    private function setDeliveryMethod()
    {
        if ($this->deliveryDays === 1) {
            $this->deliveryMethod = self::DELIVERY_METHOD_ONE_DAY;
        } elseif ($this->deliveryDays === 2) {
            $this->deliveryMethod = self::DELIVERY_METHOD_TWO_DAY;
        } else {
            $this->deliveryMethod = self::DELIVERY_METHOD_STANDARD;
        }
    }

    public function getDeliveryMethod()
    {
        return $this->deliveryMethod;
    }

    public function getDeliveryMethodText()
    {
        if (! isset(self::getDeliveryMethodMapping()[$this->deliveryMethod])) {
            return null;
        }

        return self::getDeliveryMethodMapping()[$this->deliveryMethod];
    }

    public static function getDeliveryMethodMapping()
    {
        return [
            self::DELIVERY_METHOD_STANDARD => 'Standard',
            self::DELIVERY_METHOD_ONE_DAY => 'One-Day',
            self::DELIVERY_METHOD_TWO_DAY => 'Two-Day',
        ];
    }

    public function getDTOBuilder()
    {
        return new ShipmentRateDTOBuilder($this);
    }
}
