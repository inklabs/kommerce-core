<?php
namespace inklabs\kommerce\Entity;

class Address
{
    protected $attention;
    protected $company;
    protected $address1;
    protected $address2;
    protected $city;
    protected $state;
    protected $zip5;
    protected $zip4;
    protected $latitude;
    protected $longitude;

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

    public function getLatitude()
    {
        return $this->latitude;
    }

    public function setLatitude($latitude)
    {
        $this->latitude = (float) $latitude;
    }

    public function getLongitude()
    {
        return $this->longitude;
    }

    public function setLongitude($longitude)
    {
        $this->longitude = (float) $longitude;
    }

    public function getView()
    {
        return new View\Address($this);
    }
}
