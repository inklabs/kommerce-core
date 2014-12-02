<?php
namespace inklabs\kommerce\Entity;

class Promotion
{
    use Accessor\Time;

    protected $id;
    protected $name;
    protected $type; // fixed, percent, exact
    protected $value;
    protected $redemptions = 0;
    protected $maxRedemptions;
    protected $reducesTaxSubtotal;
    protected $start;
    protected $end;

    public function __construct()
    {
        $this->setCreated();
        $this->reducesTaxSubtotal = true;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setType($type)
    {
        $this->type = $type;
    }

    public function getType()
    {
        return $this->type;
    }

    public function setValue($value)
    {
        $this->value = $value;
    }

    public function getValue()
    {
        return $this->value;
    }

    public function setRedemptions($redemptions)
    {
        $this->redemptions = $redemptions;
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

    public function setReducesTaxSubtotal($reducesTaxSubtotal)
    {
        $this->reducesTaxSubtotal = $reducesTaxSubtotal;
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
        if ($this->maxRedemptions !== null and $this->redemptions >= $this->maxRedemptions) {
            return false;
        } else {
            return true;
        }
    }

    /**
     * @return int
     * @throws \Exception
     */
    public function getUnitPrice($unitPrice)
    {
        switch ($this->type) {
            case 'fixed':
                return (int) ($unitPrice - $this->value);
                break;

            case 'percent':
                return (int) ($unitPrice - ($unitPrice * ($this->value / 100)));
                break;

            case 'exact':
                return (int) $this->value;
                break;
        }

        throw new \Exception('Invalid discount type');
    }
}
