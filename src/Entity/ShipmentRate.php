<?php
namespace inklabs\kommerce\Entity;

use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;

class ShipmentRate implements EntityInterface, ValidationInterface
{
    use IdTrait, TimeTrait;

    /** @var int */
    protected $rate;

    /** @var string */
    protected $currency;

    /** @var string */
    protected $externalId;

    /** @var string */
    protected $service;

    /** @var string */
    protected $carrier;

    /**
     * @param int $rate
     * @param string $currency
     */
    public function __construct($rate, $currency = 'USD')
    {
        $this->rate = (int) $rate;
        $this->currency = (string) $currency;
    }

    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraint('rate', new Assert\NotNull);
        $metadata->addPropertyConstraint('rate', new Assert\Range([
            'min' => 0,
            'max' => 4294967295,
        ]));

        $metadata->addPropertyConstraint('currency', new Assert\NotBlank);
        $metadata->addPropertyConstraint('currency', new Assert\Length([
            'max' => 3,
        ]));

        $metadata->addPropertyConstraint('externalId', new Assert\Length([
            'max' => 30,
        ]));

        $metadata->addPropertyConstraint('service', new Assert\Length([
            'max' => 20,
        ]));

        $metadata->addPropertyConstraint('carrier', new Assert\Length([
            'max' => 20,
        ]));
    }

    public function getRate()
    {
        return $this->rate;
    }

    public function getCurrency()
    {
        return $this->currency;
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
}
