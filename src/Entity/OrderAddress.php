<?php
namespace inklabs\kommerce\Entity;

use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;

class OrderAddress implements ValidationInterface
{
    /** @var string|null */
    protected $firstName;

    /** @var string|null */
    protected $lastName;

    /** @var string|null */
    protected $company;

    /** @var string|null */
    protected $address1;

    /** @var string|null */
    protected $address2;

    /** @var string|null */
    protected $city;

    /** @var string|null */
    protected $state;

    /** @var string|null */
    protected $zip5;

    /** @var string|null */
    protected $zip4;

    /** @var string|null */
    protected $phone;

    /** @var string|null */
    protected $email;

    /** @var string|null */
    protected $country;

    /** @var boolean|null */
    protected $isResidential;

    public function __construct()
    {
        $this->setIsResidential(true);
    }

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

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(?string $firstName)
    {
        $this->firstName = $firstName;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(?string $lastName)
    {
        $this->lastName = $lastName;
    }

    public function getCompany(): ?string
    {
        return $this->company;
    }

    public function setCompany(?string $company)
    {
        $this->company = $company;
    }

    public function getAddress1(): ?string
    {
        return $this->address1;
    }

    public function setAddress1(?string $address1)
    {
        $this->address1 = $address1;
    }

    public function getAddress2(): ?string
    {
        return $this->address2;
    }

    public function setAddress2(?string $address2)
    {
        $this->address2 = $address2;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(?string $city)
    {
        $this->city = $city;
    }

    public function getState(): ?string
    {
        return $this->state;
    }

    public function setState(?string $state)
    {
        $this->state = $state;
    }

    public function getZip5(): ?string
    {
        return $this->zip5;
    }

    public function setZip5(?string $zip5)
    {
        $this->zip5 = $zip5;
    }

    public function getZip4(): ?string
    {
        return $this->zip4;
    }

    public function setZip4(?string $zip4)
    {
        $this->zip4 = $zip4;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(?string $phone)
    {
        $this->phone = $phone;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email)
    {
        $this->email = $email;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(?string $country)
    {
        $this->country = $country;
    }

    public function isResidential(): ?bool
    {
        return $this->isResidential;
    }

    public function setIsResidential(?bool $isResidential)
    {
        $this->isResidential = $isResidential;
    }

    public function getFullName(): string
    {
        return trim($this->firstName . ' ' . $this->lastName);
    }
}
