<?php
namespace inklabs\kommerce\Entity;

use inklabs\kommerce\EntityDTO\Builder\PromotionTypeDTOBuilder;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @method static PromotionType createById($id)
 */
class PromotionType extends AbstractIntegerType
{
    const FIXED = 0;
    const PERCENT   = 1;
    const EXACT = 2;

    public static function getNameMap()
    {
        return [
            self::FIXED => 'Fixed',
            self::PERCENT => 'Percent',
            self::EXACT => 'Exact',
        ];
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

    /**
     * @return PromotionTypeDTOBuilder
     */
    public function getDTOBuilder()
    {
        return new PromotionTypeDTOBuilder($this);
    }
}
