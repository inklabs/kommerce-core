<?php
namespace inklabs\kommerce\Entity;

use inklabs\kommerce\EntityDTO\Builder\AddressDTOBuilder;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;

class Address implements ValidationInterface
{
    /** @var string */
    protected $attention;

    /** @var string */
    protected $company;

    /** @var string */
    protected $address1;

    /** @var string */
    protected $address2;

    /** @var string */
    protected $city;

    /** @var string */
    protected $state;

    /** @var string */
    protected $zip5;

    /** @var string */
    protected $zip4;

    /** @var Point */
    protected $point;

    public function __construct()
    {
        $this->point = new Point;
    }

    public static function loadValidatorMetadata(ClassMetadata $metadata)
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

    public function getAddress1()
    {
        return $this->address1;
    }

    public function setAddress1($address1)
    {
        $this->address1 = (string) $address1;
    }

    public function getAddress2()
    {
        return $this->address2;
    }

    public function setAddress2($address2)
    {
        $this->address2 = (string) $address2;
    }

    public function getAttention()
    {
        return $this->attention;
    }

    public function setAttention($attention)
    {
        $this->attention = (string) $attention;
    }

    public function getCity()
    {
        return $this->city;
    }

    public function setCity($city)
    {
        $this->city = (string) $city;
    }

    public function getCompany()
    {
        return $this->company;
    }

    public function setCompany($company)
    {
        $this->company = (string) $company;
    }

    public function getState()
    {
        return $this->state;
    }

    public function setState($state)
    {
        $this->state = (string) $state;
    }

    public function getZip4()
    {
        return $this->zip4;
    }

    public function setZip4($zip4)
    {
        $this->zip4 = (string) $zip4;
    }

    public function getZip5()
    {
        return $this->zip5;
    }

    public function setZip5($zip5)
    {
        $this->zip5 = (string) $zip5;
    }

    public function getPoint()
    {
        return $this->point;
    }

    public function setPoint(Point $point)
    {
        $this->point = $point;
    }
}
