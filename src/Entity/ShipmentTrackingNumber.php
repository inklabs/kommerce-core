<?php
namespace inklabs\kommerce\Entity;

use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;

class ShipmentTrackingNumber implements EntityInterface, ValidationInterface
{
    use IdTrait, TimeTrait;

    /** @var int */
    private $carrier;
    const CARRIER_UPS = 0;
    const CARRIER_USPS = 1;
    const CARRIER_FEDEX = 2;

    /** @var string */
    private $trackingNumber;

    /**
     * @param int $carrier
     * @param string $trackingNumber
     */
    public function __construct($carrier, $trackingNumber)
    {
        $this->setCarrier($carrier);
        $this->trackingNumber = (string) $trackingNumber;
    }

    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraint('carrier', new Assert\Choice([
            'choices' => array_keys(static::getCarrierMapping()),
            'message' => 'The carrier is not a valid choice',
        ]));

        $metadata->addPropertyConstraint('trackingNumber', new Assert\NotBlank);
        $metadata->addPropertyConstraint('trackingNumber', new Assert\Length([
            'max' => 255,
        ]));
    }

    /**
     * @param int $carrier
     */
    private function setCarrier($carrier)
    {
        $this->carrier = $carrier;
    }

    public function getCarrier()
    {
        return $this->carrier;
    }

    public static function getCarrierMapping()
    {
        return [
            static::CARRIER_UPS => 'UPS',
            static::CARRIER_USPS => 'USPS',
            static::CARRIER_FEDEX => 'FEDEX',
        ];
    }

    public function getTrackingNumber()
    {
        return $this->trackingNumber;
    }
}
