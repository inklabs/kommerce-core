<?php
namespace inklabs\kommerce\Entity;

use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;

class DeliveryMethodType extends AbstractIntegerType
{
    const STANDARD = 0;
    const ONE_DAY  = 1;
    const TWO_DAY  = 2;

    public static function getNameMap()
    {
        return [
            self::STANDARD => 'Standard',
            self::ONE_DAY => 'One-Day',
            self::TWO_DAY => 'Two-Day',
        ];
    }

    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraint('id', new Assert\Choice([
            'choices' => self::validIds(),
            'message' => 'The delivery method is not a valid choice',
        ]));
    }

    public static function standard()
    {
        return new self(self::STANDARD);
    }

    public static function oneDay()
    {
        return new self(self::ONE_DAY);
    }

    public static function twoDay()
    {
        return new self(self::TWO_DAY);
    }

    /**
     * @param int $deliveryDays
     * @return DeliveryMethodType
     */
    public static function createByDeliveryDays($deliveryDays)
    {
        if ($deliveryDays === 1) {
            return self::oneDay();
        } elseif ($deliveryDays === 2) {
            return self::twoDay();
        } else {
            return self::standard();
        }
    }

    public function isStandard()
    {
        return $this->id === self::STANDARD;
    }

    public function isOneDay()
    {
        return $this->id === self::ONE_DAY;
    }

    public function isTwoDay()
    {
        return $this->id === self::TWO_DAY;
    }
}
