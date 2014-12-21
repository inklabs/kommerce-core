<?php
namespace inklabs\kommerce\Entity;

class UserRole
{
    use Accessor\Time;

    protected $id;
    protected $name;
    protected $description;

    public function __construct()
    {
        $this->setCreated();
    }

    public function setId($id)
    {
        $this->id = (int) $id;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setName($name)
    {
        $this->name = (string) $name;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setDescription($description)
    {
        $this->description = (string) $description;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function getView()
    {
        return new View\UserRole($this);
    }
}
