<?php
namespace inklabs\kommerce\Entity;

use inklabs\kommerce\EntityDTO\Builder\ShipmentCarrierTypeDTOBuilder;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @method static ShipmentCarrierType createById($id)
 */
class ShipmentCarrierType extends AbstractIntegerType
{
    const UNKNOWN = 0;
    const UPS     = 1;
    const USPS    = 2;
    const FEDEX   = 3;

    public static function getNameMap()
    {
        return [
            self::UNKNOWN => 'Unknown',
            self::UPS => 'UPS',
            self::USPS => 'USPS',
            self::FEDEX => 'FedEx',
        ];
    }

    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraint('id', new Assert\Choice([
            'choices' => self::validIds(),
            'message' => 'The carrier is not a valid choice',
        ]));
    }

    public static function unknown()
    {
        return new self(self::UNKNOWN);
    }

    public static function ups()
    {
        return new self(self::UPS);
    }

    public static function usps()
    {
        return new self(self::USPS);
    }

    public static function fedex()
    {
        return new self(self::FEDEX);
    }

    public function isUnknown()
    {
        return $this->id === self::UNKNOWN;
    }

    public function isUps()
    {
        return $this->id === self::UPS;
    }

    public function isUsps()
    {
        return $this->id === self::USPS;
    }

    public function isFedex()
    {
        return $this->id === self::FEDEX;
    }

    /**
     * @return ShipmentCarrierTypeDTOBuilder
     */
    public function getDTOBuilder()
    {
        return new ShipmentCarrierTypeDTOBuilder($this);
    }
}
