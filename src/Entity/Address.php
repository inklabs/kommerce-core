<?php
namespace inklabs\kommerce\Entity;

use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;

class Address implements ValidationInterface
{
    /** @var string|null */
    protected $attention;

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

    /** @var Point */
    protected $point;

    public function __construct()
    {
        $this->point = new Point();
    }

    public static function loadValidatorMetadata(ClassMetadata $metadata): void
    {
        $metadata->addPropertyConstraint('attention', new Assert\NotBlank);
        $metadata->addPropertyConstraint('attention', new Assert\Length([
            'max' => 128,
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

        $metadata->addPropertyConstraint('zip4', new Assert\Regex([
            'pattern' => '/[0-9]{4}/',
            'match'   => true,
            'message' => 'Must be a valid 4 digit ZIP+4 postal code',
        ]));

        $metadata->addPropertyConstraint('point', new Assert\Valid);
    }

    public function getAddress1(): ?string
    {
        return $this->address1;
    }

    public function setAddress1(string $address1)
    {
        $this->address1 = $address1;
    }

    public function getAddress2(): ?string
    {
        return $this->address2;
    }

    public function setAddress2(string $address2)
    {
        $this->address2 = $address2;
    }

    public function getAttention(): ?string
    {
        return $this->attention;
    }

    public function setAttention(string $attention)
    {
        $this->attention = $attention;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city)
    {
        $this->city = $city;
    }

    public function getCompany(): ?string
    {
        return $this->company;
    }

    public function setCompany(string $company)
    {
        $this->company = $company;
    }

    public function getState(): ?string
    {
        return $this->state;
    }

    public function setState(string $state)
    {
        $this->state = $state;
    }

    public function getZip4(): ?string
    {
        return $this->zip4;
    }

    public function setZip4(string $zip4)
    {
        $this->zip4 = $zip4;
    }

    public function getZip5(): ?string
    {
        return $this->zip5;
    }

    public function setZip5(string $zip5)
    {
        $this->zip5 = $zip5;
    }

    public function getPoint(): Point
    {
        return $this->point;
    }

    public function setPoint(Point $point)
    {
        $this->point = $point;
    }
}
