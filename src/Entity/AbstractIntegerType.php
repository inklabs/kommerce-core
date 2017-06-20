<?php
namespace inklabs\kommerce\Entity;

use inklabs\kommerce\Exception\InvalidArgumentException;

abstract class AbstractIntegerType implements ValidationInterface, NameMapInterface, SlugMapInterface
{
    /** @var int|null */
    protected $id;

    protected function __construct(int $id)
    {
        if (! in_array($id, static::validIds())) {
            throw new InvalidArgumentException;
        }

        $this->id = $id;
    }

    protected static function validIds(): array
    {
        return array_keys(static::getNameMap());
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->getNameMap()[$this->id];
    }

    /**
     * @param int $id
     * @return static
     */
    public static function createById(int $id)
    {
        return new static($id);
    }

    public static function getSlugNameMap(): array
    {
        $slugNameMap = [];
        $nameMap = static::getNameMap();

        foreach (static::getSlugMap() as $key => $slug) {
            $slugNameMap[$slug] = $nameMap[$key];
        }

        return $slugNameMap;
    }

    public function getSlug(): string
    {
        return static::getSlugMap()[$this->id];
    }

    /**
     * @param string $slug
     * @return static
     */
    public static function createBySlug(string $slug)
    {
        $id = array_search($slug, static::getSlugMap());
        return self::createById($id);
    }
}
