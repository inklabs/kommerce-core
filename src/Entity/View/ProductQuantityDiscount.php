<?php
namespace inklabs\kommerce\Entity\View;

use inklabs\kommerce\Entity as Entity;

class ProductQuantityDiscount extends Promotion
{
    public $customerGroup;
    public $quantity;

    public function __construct(Entity\ProductQuantityDiscount $productQuantityDiscount)
    {
        parent::__construct($productQuantityDiscount);

        $this->customerGroup = $productQuantityDiscount->getCustomerGroup();
        $this->quantity      = $productQuantityDiscount->getQuantity();
    }

    public function withAllData()
    {
        return $this;
    }
}
