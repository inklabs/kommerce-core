<?php
namespace inklabs\kommerce\Entity;

class Coupon extends Promotion
{
    use Accessors;

    public $id;
    public $code;
    public $name;
    public $free_shipping = false;
    public $reduces_tax_subtotal = true;
    public $min_order_value;
    public $max_order_value;
    public $created;

    public function isValid(\DateTime $date, $subtotal)
    {
        return $this->isValidPromotion($date)
            and $this->isMinOrderValueValid($subtotal)
            and $this->isMaxOrderValueValid($subtotal);
    }

    public function isMinOrderValueValid($subtotal)
    {
        if ($this->min_order_value !== null and $subtotal < $this->min_order_value) {
            return false;
        } else {
            return true;
        }
    }

    public function isMaxOrderValueValid($subtotal)
    {
        if ($this->max_order_value !== null and $subtotal > $this->max_order_value) {
            return false;
        } else {
            return true;
        }
    }
}
