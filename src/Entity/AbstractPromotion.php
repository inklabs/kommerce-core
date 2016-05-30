<?php
namespace inklabs\kommerce\Entity;

use DateTime;
use inklabs\kommerce\EntityDTO\Builder\AbstractPromotionDTOBuilder;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;

abstract class AbstractPromotion implements IdEntityInterface, ValidationInterface
{
    use TimeTrait, IdTrait;

    /** @var string */
    protected $name;

    /** @var PromotionType */
    protected $type;

    /** @var int */
    protected $value;

    /** @var int */
    protected $redemptions;

    /** @var int */
    protected $maxRedemptions;

    /** @var boolean */
    protected $reducesTaxSubtotal;

    /** @var int|null */
    protected $start;

    /** @var int|null */
    protected $end;

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

    public function setRedemptions($redemptions)
    {
        $this->redemptions = (int) $redemptions;
    }

    public function getRedemptions()
    {
        return $this->redemptions;
    }

    public function setMaxRedemptions($maxRedemptions)
    {
        $this->maxRedemptions = $maxRedemptions;
    }

    public function getMaxRedemptions()
    {
        return $this->maxRedemptions;
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

    public function setStart(DateTime $start = null)
    {
        if ($start === null) {
            $this->start = null;
        } else {
            $this->start = $start->getTimestamp();
        }
    }

    public function getStart()
    {
        if ($this->start === null) {
            return null;
        }

        $start = new DateTime();
        $start->setTimestamp($this->start);
        return $start;
    }

    public function setEnd(DateTime $end = null)
    {
        if ($end === null) {
            $this->end = null;
        } else {
            $this->end = $end->getTimestamp();
        }
    }

    public function getEnd()
    {
        if ($this->end === null) {
            return null;
        }

        $end = new DateTime();
        $end->setTimestamp($this->end);
        return $end;
    }

    public function isValidPromotion(DateTime $date)
    {
        return $this->isDateValid($date)
            and $this->isRedemptionCountValid();
    }

    public function isDateValid(DateTime $date)
    {
        $currentDateTs = $date->getTimestamp();

        if (($this->start !== null) && ($currentDateTs < $this->start)) {
            return false;
        }

        if (($this->end !== null) && ($currentDateTs > $this->end)) {
            return false;
        }

        return true;
    }

    public function isRedemptionCountValid()
    {
        if ($this->maxRedemptions === null) {
            return true;
        } elseif ($this->redemptions < $this->maxRedemptions) {
            return true;
        } else {
            return false;
        }
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
