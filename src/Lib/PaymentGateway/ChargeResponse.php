<?php
namespace inklabs\kommerce\Lib\PaymentGateway;

use inklabs\kommerce\Entity\ValidationInterface;
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

    public function getExternalId(): string
    {
        return $this->externalId;
    }

    public function setExternalId(string $externalId = null): void
    {
        $this->externalId = $externalId;
    }

    public function getAmount(): int
    {
        return $this->amount;
    }

    public function setAmount(int $amount): void
    {
        $this->amount = $amount;
    }

    public function getLast4(): string
    {
        return $this->last4;
    }

    public function setLast4(string $last4): void
    {
        $this->last4 = $last4;
    }

    public function getBrand(): string
    {
        return $this->brand;
    }

    public function setBrand(string $brand): void
    {
        $this->brand = $brand;
    }

    public function getCreated(): int
    {
        return $this->created;
    }

    public function setCreated(int $created): void
    {
        $this->created = $created;
    }

    public function getCurrency(): string
    {
        return $this->currency;
    }

    public function setCurrency(string $currency): void
    {
        $this->currency = $currency;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }
}
