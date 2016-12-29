<?php
namespace inklabs\kommerce\Entity;

use inklabs\kommerce\Exception\InvalidArgumentException;

abstract class AbstractIntegerType implements ValidationInterface, NameMapInterface, SlugMapInterface
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
     * @return static
     */
    public static function createById($id)
    {
        return new static($id);
    }

        /**
     * @return array
     */
    public static function getSlugNameMap()
    {
        $slugNameMap = [];
        $nameMap = static::getNameMap();

        foreach (static::getSlugMap() as $key => $slug) {
            $slugNameMap[$slug] = $nameMap[$key];
        }

        return $slugNameMap;
    }

    /**
     * @return string
     */
    public function getSlug()
    {
        return static::getSlugMap()[$this->id];
    }

    /**
     * @param string $slug
     * @return static
     */
    public static function createBySlug($slug)
    {
        $id = array_search($slug, static::getSlugMap());
        return self::createById($id);
    }
}
