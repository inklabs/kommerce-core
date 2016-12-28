<?php
namespace inklabs\kommerce\Entity;

use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;

class PromotionType extends AbstractIntegerType
{
    const FIXED = 0;
    const PERCENT = 1;
    const EXACT = 2;

    public static function getNameMap()
    {
        return [
            self::FIXED => 'Fixed',
            self::PERCENT => 'Percent',
            self::EXACT => 'Exact',
        ];
    }

    public static function getSlugMap()
    {
        return [
            self::FIXED => 'fixed',
            self::PERCENT => 'percent',
            self::EXACT => 'exact',
        ];
    }

    /**
     * @TODO Move up to AbstractIntegerType
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

    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraint('id', new Assert\Choice([
            'choices' => self::validIds(),
            'message' => 'The type is not a valid choice',
        ]));
    }

    public static function fixed()
    {
        return new self(self::FIXED);
    }

    public static function percent()
    {
        return new self(self::PERCENT);
    }

    public static function exact()
    {
        return new self(self::EXACT);
    }

    public function isFixed()
    {
        return $this->id === self::FIXED;
    }

    public function isPercent()
    {
        return $this->id === self::PERCENT;
    }

    public function isExact()
    {
        return $this->id === self::EXACT;
    }
}
