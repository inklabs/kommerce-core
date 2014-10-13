<?php
namespace inklabs\kommerce\Entity;

class ProductQuantityDiscount extends Promotion
{
    public $id;
    public $name;
    public $customer_group;
    public $quantity;
    public $created;
    public $updated;

    public function is_valid(\DateTime $date, $quantity)
    {
        return parent::is_valid($date)
            AND $this->is_quantity_valid($quantity);
    }

    public function is_quantity_valid($quantity)
    {
        if ($quantity >= $this->quantity) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
}
