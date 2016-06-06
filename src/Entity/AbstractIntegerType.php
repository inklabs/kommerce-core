<?php
namespace inklabs\kommerce\Entity;

use inklabs\kommerce\Exception\InvalidArgumentException;

abstract class AbstractIntegerType implements ValidationInterface, NameMapInterface
{
    /** @var int */
    protected $id;

    /**
     * @param int $id
     * @throws InvalidArgumentException
     */
    protected function __construct($id)
    {
        if (! in_array($id, static::validIds())) {
            throw new InvalidArgumentException;
        }

        $this->id = (int) $id;
    }

    /**
     * @return array
     */
    protected static function validIds()
    {
        return array_keys(static::getNameMap());
    }

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->getNameMap()[$this->id];
    }

    /**
     * @param int $id
     * @return AbstractIntegerType
     */
    public static function createById($id)
    {
        return new static($id);
    }
}
