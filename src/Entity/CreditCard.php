<?php
namespace inklabs\kommerce\Entity;

use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;

class CreditCard implements ValidationInterface
{
    /** @var string */
    protected $name;

    /** @var string */
    protected $zip5;

    /** @var string */
    protected $number;

    /** @var string */
    protected $cvc;

    /** @var string */
    protected $expirationMonth;

    /** @var string */
    protected $expirationYear;

    public static function loadValidatorMetadata(ClassMetadata $metadata): void
    {
        $metadata->addPropertyConstraint('name', new Assert\NotBlank);
        $metadata->addPropertyConstraint('name', new Assert\Length([
            'max' => 128,
        ]));

        $metadata->addPropertyConstraint('zip5', new Assert\NotBlank);
        $metadata->addPropertyConstraint('zip5', new Assert\Regex([
            'pattern' => '/[0-9]{5}/',
            'match'   => true,
            'message' => 'Must be a valid 5 digit postal code',
        ]));

        $metadata->addPropertyConstraint('number', new Assert\NotBlank);
        $metadata->addPropertyConstraint('number', new Assert\Length([
            'max' => 16,
        ]));

        $metadata->addPropertyConstraint('cvc', new Assert\NotBlank);
        $metadata->addPropertyConstraint('cvc', new Assert\Length([
            'max' => 4,
        ]));

        $metadata->addPropertyConstraint('expirationMonth', new Assert\NotBlank);
        $metadata->addPropertyConstraint('expirationMonth', new Assert\Length([
            'min' => 2,
            'max' => 2,
        ]));

        $metadata->addPropertyConstraint('expirationYear', new Assert\NotBlank);
        $metadata->addPropertyConstraint('expirationYear', new Assert\Length([
            'min' => 4,
            'max' => 4,
        ]));
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name)
    {
        $this->name = $name;
    }

    public function getZip5(): ?string
    {
        return $this->zip5;
    }

    public function setZip5(string $zip5)
    {
        $this->zip5 = $zip5;
    }

    public function setNumber(string $number)
    {
        $this->number = $number;
    }

    public function getNumber(): ?string
    {
        return $this->number;
    }

    public function getCvc(): ?string
    {
        return $this->cvc;
    }

    public function setCvc(string $cvc)
    {
        $this->cvc = $cvc;
    }

    public function setExpirationMonth(string $expirationMonth)
    {
        if ($expirationMonth > 0) {
            $this->expirationMonth = str_pad((string)$expirationMonth, 2, '0', STR_PAD_LEFT);
        }
    }

    public function getExpirationMonth(): ?string
    {
        return $this->expirationMonth;
    }

    public function setExpirationYear(string $expirationYear)
    {
        $this->expirationYear = $expirationYear;
    }

    public function getExpirationYear(): ?string
    {
        return $this->expirationYear;
    }
}
