<?php
namespace inklabs\kommerce\Entity;

class Promotion
{
    public $discount_type; // fixed, percent, exact
    public $value;
    public $redemptions;
    public $max_redemptions;
    private $reducesTaxSubtotal = true;
    public $start;
    public $end;

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
        if ($this->max_redemptions !== null and $this->redemptions >= $this->max_redemptions) {
            return false;
        } else {
            return true;
        }
    }

    public function setReducesTaxSubtotal($reducesTaxSubtotal)
    {
        $this->reducesTaxSubtotal = $reducesTaxSubtotal;
    }

    public function reducesTaxSubtotal()
    {
        return $this->reducesTaxSubtotal;
    }

    public function getUnitPrice($unit_price)
    {
        switch ($this->discount_type) {
            case 'fixed':
                return (int) ($unit_price - $this->value);
                break;

            case 'percent':
                return (int) ($unit_price - ($unit_price * ($this->value / 100)));
                break;

            case 'exact':
                return (int) $this->value;
                break;

            default:
                throw new \Exception('Invalid discount type');
        }
    }
}
