<?php
namespace inklabs\kommerce\Lib\PaymentGateway;

use inklabs\kommerce\Entity;
use inklabs\kommerce\View;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;

class ChargeResponse implements Entity\EntityInterface
{
    /** @var string */
    protected $id;

    /** @var int */
    protected $created;

    /** @var int */
    protected $amount;

    /** @var int */
    protected $last4;

    /** @var string */
    protected $brand; // Visa, American Express, MasterCard, Discover, JCB, Diners Club, or Unknown.

    /** @var string */
    protected $currency;

    /** @var int */
    protected $fee;

    /** @var string */
    protected $description;

    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraint('id', new Assert\NotBlank);
        $metadata->addPropertyConstraint('id', new Assert\Length([
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

        $metadata->addPropertyConstraint('fee', new Assert\NotNull);
        $metadata->addPropertyConstraint('fee', new Assert\Range([
            'min' => -2147483648,
            'max' => 2147483647,
        ]));

        $metadata->addPropertyConstraint('description', new Assert\NotBlank);
        $metadata->addPropertyConstraint('description', new Assert\Length([
            'max' => 255,
        ]));
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id= (string) $id;
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
