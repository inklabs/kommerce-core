<?php
namespace inklabs\kommerce\Lib\PaymentGateway;

use inklabs\kommerce\Entity\CreditCard;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;

class ChargeRequest
{
    protected $amount;
    protected $currency;
    protected $description;

    /** @var CreditCard */
    protected $creditCard;

    public function __construct(CreditCard $creditCard, $amount, $currency, $description)
    {
        $this->creditCard = $creditCard;
        $this->amount = (int) $amount;
        $this->currency = $currency;
        $this->description = $description;
    }

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
