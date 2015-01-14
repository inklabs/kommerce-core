<?php
namespace inklabs\kommerce\Entity;

use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;

class CreditCard
{
    protected $number;
    protected $expirationMonth;
    protected $expirationYear;

    public function __construct($number, $expirationMonth, $expirationYear)
    {
        $this->number = (string) $number;
        $this->expirationMonth = str_pad((string) $expirationMonth, 2, '0', STR_PAD_LEFT);
        $this->expirationYear = (string) $expirationYear;
    }

    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraint('number', new Assert\NotBlank);
        $metadata->addPropertyConstraint('number', new Assert\Length([
            'max' => 16,
        ]));

        $metadata->addPropertyConstraint('expirationMonth', new Assert\NotBlank);
        $metadata->addPropertyConstraint('expirationMonth', new Assert\Length([
            'min' => 1,
            'max' => 2,
        ]));

        $metadata->addPropertyConstraint('expirationYear', new Assert\NotBlank);
        $metadata->addPropertyConstraint('expirationYear', new Assert\Length([
            'min' => 4,
            'max' => 4,
        ]));
    }

    public function getNumber()
    {
        return $this->number;
    }

    public function getExpirationMonth()
    {
        return $this->expirationMonth;
    }

    public function getExpirationYear()
    {
        return $this->expirationYear;
    }

    public function getView()
    {
        return new View\CreditCard($this);
    }
}
