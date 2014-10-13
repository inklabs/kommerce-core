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

    public function isValid(\DateTime $date, $quantity)
    {
        return parent::isValid($date)
            and $this->isQuantityValid($quantity);
    }

    public function isQuantityValid($quantity)
    {
        if ($quantity >= $this->quantity) {
            return true;
        } else {
            return false;
        }
    }
}
