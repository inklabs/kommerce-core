<?php
namespace inklabs\kommerce\Entity;

use inklabs\kommerce\EntityDTO\Builder\OrderAddressDTOBuilder;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;

class OrderAddress implements ValidationInterface
{
    public $firstName;
    public $lastName;
    public $company;
    public $address1;
    public $address2;
    public $city;
    public $state;
    public $zip5;
    public $zip4;
    public $phone;
    public $email;

    /** @var string */
    protected $country;

    /** @var boolean */
    protected $isResidential;

    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraint('firstName', new Assert\Length([
            'max' => 32,
        ]));

        $metadata->addPropertyConstraint('lastName', new Assert\Length([
            'max' => 32,
        ]));

        $metadata->addPropertyConstraint('company', new Assert\Length([
            'max' => 128,
        ]));

        $metadata->addPropertyConstraint('address1', new Assert\NotBlank);
        $metadata->addPropertyConstraint('address1', new Assert\Length([
            'max' => 128,
        ]));

        $metadata->addPropertyConstraint('address2', new Assert\Length([
            'max' => 128,
        ]));

        $metadata->addPropertyConstraint('city', new Assert\NotBlank);
        $metadata->addPropertyConstraint('city', new Assert\Length([
            'max' => 128,
        ]));

        $metadata->addPropertyConstraint('state', new Assert\NotBlank);
        $metadata->addPropertyConstraint('state', new Assert\Length([
            'min' => 2,
            'max' => 2,
        ]));

        $metadata->addPropertyConstraint('zip5', new Assert\NotBlank);
        $metadata->addPropertyConstraint('zip5', new Assert\Regex([
            'pattern' => '/[0-9]{5}/',
            'match'   => true,
            'message' => 'Must be a valid 5 digit postal code',
        ]));

        $metadata->addPropertyConstraint('phone', new Assert\Length([
            'max' => 20,
        ]));

        $metadata->addPropertyConstraint('email', new Assert\NotBlank);
        $metadata->addPropertyConstraint('email', new Assert\Length([
            'max' => 128,
        ]));

        $metadata->addPropertyConstraint('country', new Assert\Length([
            'max' => 2,
        ]));
    }

    /**
     * @param string $country
     */
    public function setCountry($country)
    {
        $this->country = (string) $country;
    }

    /**
     * @param boolean $isResidential
     */
    public function setIsResidential($isResidential)
    {
        $this->isResidential = (bool) $isResidential;
    }

    public function getFullName()
    {
        return trim($this->firstName . ' ' . $this->lastName);
    }

    public function getDTOBuilder()
    {
        return new OrderAddressDTOBuilder($this);
    }

    public function getCountry()
    {
        return $this->country;
    }

    public function isResidential()
    {
        return $this->isResidential;
    }
}
