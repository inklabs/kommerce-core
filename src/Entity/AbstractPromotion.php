<?php
namespace inklabs\kommerce\Entity;

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

    /** @var bool */
    protected $reducesTaxSubtotal;

    /** @var \DateTime|null */
    protected $start;

    /** @var \DateTime|null */
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

        $metadata->addPropertyConstraint('start', new Assert\Date());
        $metadata->addPropertyConstraint('end', new Assert\Date());
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
     * @param bool $reducesTaxSubtotal
     */
    public function setReducesTaxSubtotal($reducesTaxSubtotal)
    {
        $this->reducesTaxSubtotal = (bool) $reducesTaxSubtotal;
    }

    public function getReducesTaxSubtotal()
    {
        return $this->reducesTaxSubtotal;
    }

    public function setStart(\DateTime $start = null)
    {
        $this->start = $start;
    }

    public function getStart()
    {
        return $this->start;
    }

    public function setEnd(\DateTime $end = null)
    {
        $this->end = $end;
    }

    public function getEnd()
    {
        return $this->end;
    }

    public function isValidPromotion(\DateTime $date)
    {
        return $this->isDateValid($date)
            and $this->isRedemptionCountValid();
    }

    public function isDateValid(\DateTime $date)
    {
        $currentDateTs = $date->getTimestamp();

        $start = $this->getStart();
        $end = $this->getEnd();

        if (($start !== null) and ($currentDateTs < $start->getTimestamp())) {
            return false;
        }

        if (($end !== null) and ($currentDateTs > $end->getTimestamp())) {
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
     * @throws \Exception
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

        throw new \Exception('Invalid discount type');
    }

    /**
     * @return AbstractPromotionDTOBuilder
     */
    abstract public function getDTOBuilder();
}
