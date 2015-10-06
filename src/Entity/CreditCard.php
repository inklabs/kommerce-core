<?php
namespace inklabs\kommerce\Entity;

use inklabs\kommerce\EntityDTO\Builder\CreditCardDTOBuilder;
use inklabs\kommerce\View;
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

    public static function loadValidatorMetadata(ClassMetadata $metadata)
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

    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = (string) $name;
    }

    public function getZip5()
    {
        return $this->zip5;
    }

    /**
     * @param string $zip5
     */
    public function setZip5($zip5)
    {
        $this->zip5 = (string) $zip5;
    }

    /**
     * @param string $number
     */
    public function setNumber($number)
    {
        $this->number = (string) $number;
    }

    public function getNumber()
    {
        return $this->number;
    }

    public function getCvc()
    {
        return $this->cvc;
    }

    /**
     * @param string $cvc
     */
    public function setCvc($cvc)
    {
        $this->cvc = (string) $cvc;
    }

    /**
     * @param string $expirationMonth
     */
    public function setExpirationMonth($expirationMonth)
    {
        if ($expirationMonth > 0) {
            $this->expirationMonth = str_pad((string)$expirationMonth, 2, '0', STR_PAD_LEFT);
        }
    }

    public function getExpirationMonth()
    {
        return $this->expirationMonth;
    }

    /**
     * @param string $expirationYear
     */
    public function setExpirationYear($expirationYear)
    {
        $this->expirationYear = (string) $expirationYear;
    }

    public function getExpirationYear()
    {
        return $this->expirationYear;
    }

    public function getView()
    {
        return new View\CreditCard($this);
    }

    public function getDTOBuilder()
    {
        return new CreditCardDTOBuilder($this);
    }
}
