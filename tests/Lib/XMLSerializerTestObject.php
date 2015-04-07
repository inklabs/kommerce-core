<?php
namespace inklabs\kommerce\tests\Lib;

class XMLSerializerTestObject
{
    /** @var int */
    protected $id;

    /** @var string */
    protected $name;

    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = (int) $id;
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
}
