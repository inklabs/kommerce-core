<?php
namespace inklabs\kommerce\Entity;

class Promotion
{
    use Accessor\Time;

    protected $id;
    protected $name;
    protected $discountType; // fixed, percent, exact
    protected $value;
    protected $redemptions;
    protected $maxRedemptions;
    protected $reducesTaxSubtotal;
    protected $start;
    protected $end;

    public function __construct()
    {
        $this->reducesTaxSubtotal = true;
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

    public function setDiscountType($discountType)
    {
        $this->discountType = $discountType;
    }

    public function getDiscountType()
    {
        return $this->discountType;
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

    public function setStart(\DateTime $start)
    {
        $this->start = $start;
    }

    public function getStart()
    {
        return $this->start;
    }

    public function setEnd(\DateTime $end)
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
        $current_date_ts = $date->getTimestamp();

        if ($current_date_ts >= $this->start->getTimestamp() and $current_date_ts <= $this->end->getTimestamp()) {
            return true;
        } else {
            return false;
        }
    }

    public function isRedemptionCountValid()
    {
        if ($this->maxRedemptions !== null and $this->redemptions >= $this->maxRedemptions) {
            return false;
        } else {
            return true;
        }
    }

    public function getUnitPrice($unitPrice)
    {
        switch ($this->discountType) {
            case 'fixed':
                return (int) ($unitPrice - $this->value);
                break;

            case 'percent':
                return (int) ($unitPrice - ($unitPrice * ($this->value / 100)));
                break;

            case 'exact':
                return (int) $this->value;
                break;

            default:
                throw new \Exception('Invalid discount type');
        }
    }
}
