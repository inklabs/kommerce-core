<?php
namespace inklabs\kommerce\Entity;

use DateTime;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;

class ShipmentRate implements ValidationInterface
{
    /** @var string|null */
    protected $externalId;

    /** @var string|null */
    protected $shipmentExternalId;

    /** @var string|null */
    protected $service;

    /** @var string|null */
    protected $carrier;

    /** @var int|null */
    protected $deliveryDate;

    /** @var boolean|null */
    protected $isDeliveryDateGuaranteed;

    /** @var int|null */
    protected $deliveryDays;

    /** @var int|null */
    protected $estDeliveryDays;

    /** @var DeliveryMethodType */
    protected $deliveryMethod;

    /** @var Money */
    protected $rate;

    /** @var Money */
    protected $listRate;

    /** @var Money */
    protected $retailRate;

    public function __construct(Money $rate)
    {
        $this->rate = $rate;
        $this->setIsDeliveryDateGuaranteed(false);
        $this->setupDeliveryMethod();
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

        $metadata->addPropertyConstraint('deliveryMethod', new Assert\Valid);
    }

    public function getRate(): Money
    {
        return $this->rate;
    }

    public function setService(string $service)
    {
        $this->service = $service;
    }

    public function getService(): ?string
    {
        return $this->service;
    }

    public function setCarrier(string $carrier)
    {
        $this->carrier = $carrier;
    }

    public function getCarrier(): ?string
    {
        return $this->carrier;
    }

    public function setExternalId(string $externalId)
    {
        $this->externalId = $externalId;
    }

    public function getExternalId(): ?string
    {
        return $this->externalId;
    }

    public function setShipmentExternalId(string $shipmentExternalId)
    {
        $this->shipmentExternalId = $shipmentExternalId;
    }

    public function getShipmentExternalId(): ?string
    {
        return $this->shipmentExternalId;
    }

    public function setDeliveryDate(DateTime $deliveryDate = null)
    {
        $this->deliveryDate = $deliveryDate->getTimestamp();
    }

    public function getDeliveryDate(): ?DateTime
    {
        if ($this->deliveryDate === null) {
            return null;
        }

        $deliveryDate = new DateTime();
        $deliveryDate->setTimestamp($this->deliveryDate);
        return $deliveryDate;
    }

    public function setIsDeliveryDateGuaranteed(bool $isDeliveryDateGuaranteed)
    {
        $this->isDeliveryDateGuaranteed = $isDeliveryDateGuaranteed;
    }

    public function isDeliveryDateGuaranteed(): ?bool
    {
        return $this->isDeliveryDateGuaranteed;
    }

    public function setDeliveryDays(int $deliveryDays)
    {
        $this->deliveryDays = $deliveryDays;
        $this->setupDeliveryMethod();
    }

    public function setEstDeliveryDays(int $estDeliveryDays = null)
    {
        $this->estDeliveryDays = $estDeliveryDays;
    }

    public function getDeliveryDays(): ?int
    {
        return $this->deliveryDays;
    }

    public function getEstDeliveryDays(): ?int
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

    public function getListRate(): Money
    {
        return $this->listRate;
    }

    public function getRetailRate(): ?Money
    {
        return $this->retailRate;
    }

    private function setupDeliveryMethod(): void
    {
        $this->setDeliveryMethod(
            DeliveryMethodType::createByDeliveryDays($this->deliveryDays)
        );
    }

    public function getDeliveryMethod(): DeliveryMethodType
    {
        return $this->deliveryMethod;
    }

    private function setDeliveryMethod(DeliveryMethodType $deliveryMethod)
    {
        $this->deliveryMethod = $deliveryMethod;
    }
}
