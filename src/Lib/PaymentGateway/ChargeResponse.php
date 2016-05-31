<?php
namespace inklabs\kommerce\Lib\PaymentGateway;

use inklabs\kommerce\Entity\ValidationInterface;
use inklabs\kommerce\EntityDTO\Builder\ChargeResponseDTOBuilder;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;

class ChargeResponse implements ValidationInterface
{
    /** @var string */
    protected $externalId;

    /** @var int */
    protected $amount;

    /** @var string */
    protected $last4;

    /** @var string */
    protected $brand; // Visa, American Express, MasterCard, Discover, JCB, Diners Club, or Unknown.

    /** @var string */
    protected $currency;

    /** @var string */
    protected $description;

    /** @var int */
    protected $created;

    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraint('externalId', new Assert\NotBlank);
        $metadata->addPropertyConstraint('externalId', new Assert\Length([
            'max' => 255,
        ]));

        $metadata->addPropertyConstraint('created', new Assert\NotNull);
        $metadata->addPropertyConstraint('created', new Assert\Range([
            'min' => 0,
            'max' => 4294967295,
        ]));

        $metadata->addPropertyConstraint('last4', new Assert\NotBlank);
        $metadata->addPropertyConstraint('last4', new Assert\Regex([
            'pattern' => '/^[0-9]{4}$/',
            'match'   => true,
            'message' => 'Must be the last 4 digits of a credit card number.',
        ]));

        $metadata->addPropertyConstraint('brand', new Assert\NotBlank);
        $metadata->addPropertyConstraint('brand', new Assert\Length([
            'max' => 16,
        ]));

        $metadata->addPropertyConstraint('amount', new Assert\NotNull);
        $metadata->addPropertyConstraint('amount', new Assert\Range([
            'min' => -2147483648,
            'max' => 2147483647,
        ]));

        $metadata->addPropertyConstraint('currency', new Assert\NotBlank);
        $metadata->addPropertyConstraint('currency', new Assert\Length([
            'max' => 3,
        ]));

        $metadata->addPropertyConstraint('description', new Assert\NotBlank);
        $metadata->addPropertyConstraint('description', new Assert\Length([
            'max' => 255,
        ]));
    }

    public function getExternalId()
    {
        return $this->externalId;
    }

    /**
     * @param string $externalId
     */
    public function setExternalId($externalId = null)
    {
        $this->externalId = (string) $externalId;
    }

    public function getAmount()
    {
        return $this->amount;
    }

    public function setAmount($amount)
    {
        $this->amount = (int) $amount;
    }

    public function getLast4()
    {
        return $this->last4;
    }

    public function setLast4($last4)
    {
        $this->last4 = (string) $last4;
    }

    public function getBrand()
    {
        return $this->brand;
    }

    public function setBrand($brand)
    {
        $this->brand = (string) $brand;
    }

    public function getCreated()
    {
        return $this->created;
    }

    public function setCreated($created)
    {
        $this->created = (int) $created;
    }

    public function getCurrency()
    {
        return $this->currency;
    }

    public function setCurrency($currency)
    {
        $this->currency = (string) $currency;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function setDescription($description)
    {
        $this->description = (string) $description;
    }
}
