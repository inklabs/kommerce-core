<?php
namespace inklabs\kommerce\Lib\PaymentGateway;

use inklabs\kommerce\Entity\CreditCard;
use inklabs\kommerce\Entity\ValidationInterface;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;

class ChargeRequest implements ValidationInterface
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

    public function setAmount(int $amount): void
    {
        $this->amount = $amount;
    }

    public function setCurrency(string $currency): void
    {
        $this->currency = $currency;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function setCreditCard(CreditCard $creditCard): void
    {
        $this->creditCard = $creditCard;
    }

    public function getAmount(): int
    {
        return $this->amount;
    }

    public function getCreditCard(): CreditCard
    {
        return $this->creditCard;
    }

    public function getCurrency(): string
    {
        return $this->currency;
    }

    public function getDescription(): string
    {
        return $this->description;
    }
}
