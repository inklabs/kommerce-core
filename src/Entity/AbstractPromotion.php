<?php
namespace inklabs\kommerce\Entity;

use DateTime;
use Exception;
use inklabs\kommerce\EntityDTO\Builder\AbstractPromotionDTOBuilder;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;

abstract class AbstractPromotion implements EntityInterface, ValidationInterface
{
    use TimeTrait, IdTrait;

    /** @var string */
    protected $name;

    /** @var int */
    protected $type;
    const TYPE_FIXED   = 0;
    const TYPE_PERCENT = 1;
    const TYPE_EXACT   = 2;

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
        $this->setCreated();
        $this->type = static::TYPE_FIXED;
        $this->redemptions = 0;
        $this->reducesTaxSubtotal = true;
    }

    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraint('name', new Assert\Length([
            'max' => 255,
        ]));

        $metadata->addPropertyConstraint('type', new Assert\Choice([
            'choices' => array_keys(static::getTypeMapping()),
            'message' => 'The type is not a valid choice',
        ]));

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

    public function setType($type)
    {
        $this->type = (int) $type;
    }

    public function getType()
    {
        return $this->type;
    }

    public static function getTypeMapping()
    {
        return [
            static::TYPE_FIXED => 'Fixed',
            static::TYPE_PERCENT => 'Percent',
            static::TYPE_EXACT => 'Exact',
        ];
    }

    public function getTypeText()
    {
        return $this->getTypeMapping()[$this->type];
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
     * @throws Exception
     */
    public function getUnitPrice($unitPrice)
    {
        switch ($this->type) {
            case static::TYPE_FIXED:
                return (int) ($unitPrice - $this->value);
                break;

            case static::TYPE_PERCENT:
                return (int) ($unitPrice - ($unitPrice * ($this->value / 100)));
                break;

            case static::TYPE_EXACT:
                return (int) $this->value;
                break;
        }

        throw new Exception('Invalid discount type');
    }

    /**
     * @return AbstractPromotionDTOBuilder
     */
    abstract public function getDTOBuilder();
}
