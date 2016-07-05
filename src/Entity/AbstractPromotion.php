<?php
namespace inklabs\kommerce\Entity;

use DateTime;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;

abstract class AbstractPromotion implements IdEntityInterface, ValidationInterface
{
    use TimeTrait, IdTrait, PromotionRedemptionTrait, PromotionStartEndDateTrait;

    /** @var string */
    protected $name;

    /** @var PromotionType */
    protected $type;

    /** @var int */
    protected $value;

    /** @var boolean */
    protected $reducesTaxSubtotal;

    public function __construct()
    {
        $this->setId();
        $this->setCreated();
        $this->setType(PromotionType::fixed());
        $this->setRedemptions(0);
        $this->setReducesTaxSubtotal(true);
    }

    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraint('name', new Assert\Length([
            'max' => 255,
        ]));

        $metadata->addPropertyConstraint('type', new Assert\Valid);

        $metadata->addPropertyConstraint('value', new Assert\Range([
            'min' => 0,
            'max' => 4294967295,
        ]));

        $metadata->addPropertyConstraint('redemptions', new Assert\NotNull);
        $metadata->addPropertyConstraint('redemptions', new Assert\Range([
            'min' => 0,
            'max' => 65535,
        ]));

        $metadata->addPropertyConstraint('maxRedemptions', new Assert\Range([
            'min' => 0,
            'max' => 65535,
        ]));

        $metadata->addPropertyConstraint('start', new Assert\Range([
            'min' => 0,
            'max' => 4294967295,
        ]));

        $metadata->addPropertyConstraint('end', new Assert\Range([
            'min' => 0,
            'max' => 4294967295,
        ]));
    }

    public function setName($name)
    {
        $this->name = (string) $name;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setType(PromotionType $type)
    {
        $this->type = $type;
    }

    public function getType()
    {
        return $this->type;
    }

    public function setValue($value)
    {
        $this->value = (int) $value;
    }

    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param boolean $reducesTaxSubtotal
     */
    public function setReducesTaxSubtotal($reducesTaxSubtotal)
    {
        $this->reducesTaxSubtotal = (bool) $reducesTaxSubtotal;
    }

    public function getReducesTaxSubtotal()
    {
        return $this->reducesTaxSubtotal;
    }

    public function isValidPromotion(DateTime $date)
    {
        return $this->isDateValid($date)
            and $this->isRedemptionCountValid();
    }

    /**
     * @param int $unitPrice
     * @return int
     */
    public function getUnitPrice($unitPrice)
    {
        $returnValue = 0;

        if ($this->type->isFixed()) {
            $returnValue = $unitPrice - $this->value;
        } elseif ($this->type->isPercent()) {
            $returnValue = $unitPrice - ($unitPrice * ($this->value / 100));
        } elseif ($this->type->isExact()) {
            $returnValue = $this->value;
        }

        return (int) $returnValue;
    }
}
