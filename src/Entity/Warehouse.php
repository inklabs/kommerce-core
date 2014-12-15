<?php
namespace inklabs\kommerce\Entity;

class Warehouse
{
    use Accessor\Time;

    protected $id;
    protected $name;

    /* @var Address */
    protected $address;

    public function __construct()
    {
        $this->setCreated();
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = (int) $id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = (string) $name;
    }

    /**
     * @return Address
     */
    public function getAddress()
    {
        return $this->address;
    }

    public function setAddress(Address $address)
    {
        $this->address = $address;
    }
}
