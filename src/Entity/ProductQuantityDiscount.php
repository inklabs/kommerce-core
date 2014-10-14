<?php
namespace inklabs\kommerce\Entity;

class ProductQuantityDiscount extends Promotion
{
    protected $customerGroup;
    protected $quantity;

    public function setCustomerGroup($customerGroup)
    {
        $this->customerGroup = $customerGroup;
    }

    public function getCustomerGroup()
    {
        return $this->customerGroup;
    }

    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;
    }

    public function getQuantity()
    {
        return $this->quantity;
    }

    public function isValid(\DateTime $date, $quantity)
    {
        return $this->isValidPromotion($date)
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
