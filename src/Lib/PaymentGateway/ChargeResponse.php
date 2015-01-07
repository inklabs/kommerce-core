<?php
namespace inklabs\kommerce\Lib\PaymentGateway;

use inklabs\kommerce\Entity\View as View;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;

class ChargeResponse
{
    protected $id;
    protected $created;
    protected $amount;
    protected $last4;
    protected $brand; // Visa, American Express, MasterCard, Discover, JCB, Diners Club, or Unknown.
    protected $currency;
    protected $fee;
    protected $description;

    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraint('created', new Assert\NotNull);
        $metadata->addPropertyConstraint('created', new Assert\Range([
            'min' => 0,
            'max' => 4294967295,
        ]));

        // TODO: Verify regex actually works
        $metadata->addPropertyConstraint('last4', new Assert\NotBlank);
        $metadata->addPropertyConstraint('last4', new Assert\Regex([
            'pattern' => '/[0-9]{4}/',
            'match'   => true,
            'message' => 'Must be the last 4 digits of a credit card number',
        ]));

        $metadata->addPropertyConstraint('brand', new Assert\NotBlank);
        $metadata->addPropertyConstraint('brand', new Assert\Length([
            'max' => 16,
        ]));

        // TODO: Verify integer bounds
        $metadata->addPropertyConstraint('amount', new Assert\NotNull);
        $metadata->addPropertyConstraint('amount', new Assert\Range([
            'min' => -2147483646,
            'max' => 2147483646,
        ]));

        $metadata->addPropertyConstraint('currency', new Assert\NotBlank);
        $metadata->addPropertyConstraint('currency', new Assert\Length([
            'max' => 3,
        ]));

        // TODO: Verify integer bounds
        $metadata->addPropertyConstraint('fee', new Assert\NotNull);
        $metadata->addPropertyConstraint('fee', new Assert\Range([
            'min' => -2147483646,
            'max' => 2147483646,
        ]));

        $metadata->addPropertyConstraint('description', new Assert\NotBlank);
        $metadata->addPropertyConstraint('description', new Assert\Length([
            'max' => 255,
        ]));
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

    public function getFee()
    {
        return $this->fee;
    }

    public function setFee($fee)
    {
        $this->fee = (int) $fee;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = (string) $id;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function setDescription($description)
    {
        $this->description = (string) $description;
    }

    public function getView()
    {
        return new View\ChargeResponse($this);
    }
}
