<?php
namespace inklabs\kommerce\Lib\PaymentGateway;

use inklabs\kommerce\Entity\CreditCard;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;

class ChargeRequest
{
    /** @var int */
    protected $amount;

    /** @var string */
    protected $currency;

    /** @var string */
    protected $description;

    /** @var CreditCard */
    protected $creditCard;

    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
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

        $metadata->addPropertyConstraint('creditCard', new Assert\Valid);
    }

    /**
     * @param int $amount
     */
    public function setAmount($amount)
    {
        $this->amount = (int) $amount;
    }

    /**
     * @param string $currency
     */
    public function setCurrency($currency)
    {
        $this->currency = (string) $currency;
    }

    /**
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = (string) $description;
    }

    public function setCreditCard(CreditCard $creditCard)
    {
        $this->creditCard = $creditCard;
    }

    public function getAmount()
    {
        return $this->amount;
    }

    public function getCreditCard()
    {
        return $this->creditCard;
    }

    public function getCurrency()
    {
        return $this->currency;
    }

    public function getDescription()
    {
        return $this->description;
    }
}
