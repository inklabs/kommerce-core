<?php
namespace inklabs\kommerce\Entity;

class ProductQuantityDiscount extends Promotion
{
    protected $customerGroup;
    protected $flagApplyCatalogPromotions;
    protected $quantity;
    protected $product;

    private $priceObj;

    public function getName()
    {
        $name = 'Buy ' . $this->getQuantity() . ' or more';

        if ($this->getDiscountType() == 'exact') {
            $name .= ' for $' . ($this->getValue() / 100) . ' each';
        } elseif ($this->getDiscountType() == 'percent') {
            $name .= ' for ' . $this->getValue() . '% off';
        } elseif ($this->getDiscountType() == 'fixed') {
            $name .= ' for $' . ($this->getValue() / 100) . ' off';
        }

        return $name;
    }

    public function setPriceObj($priceObj)
    {
        $this->priceObj = $priceObj;
    }

    public function getPriceObj()
    {
        return $this->priceObj;
    }

    public function setCustomerGroup($customerGroup)
    {
        $this->customerGroup = $customerGroup;
    }

    public function getCustomerGroup()
    {
        return $this->customerGroup;
    }

    public function setFlagApplyCatalogPromotions($flagApplyCatalogPromotions)
    {
        $this->flagApplyCatalogPromotions = $flagApplyCatalogPromotions;
    }

    public function getFlagApplyCatalogPromotions()
    {
        return $this->flagApplyCatalogPromotions;
    }

    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;
    }

    public function getQuantity()
    {
        return $this->quantity;
    }

    public function setProduct(Product $product)
    {
        $this->product = $product;
    }

    public function getProduct()
    {
        return $this->product;
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

    public function getView()
    {
        return new View\ProductQuantityDiscount($this);
    }
}
