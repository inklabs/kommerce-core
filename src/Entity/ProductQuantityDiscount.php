<?php
namespace inklabs\kommerce\Entity;

use inklabs\kommerce\Service\Pricing;

class ProductQuantityDiscount extends Promotion
{
    protected $customerGroup;
    protected $flagApplyCatalogPromotions;
    protected $quantity;
    protected $product;

    public function setName($name)
    {
        throw new \Exception('Unable to set name.');
    }

    public function getName()
    {
        $name = 'Buy ' . $this->getQuantity() . ' or more for ';

        if ($this->getDiscountType() == 'exact') {
            $name .= $this->displayCents($this->getValue()) . ' each';
        } elseif ($this->getDiscountType() == 'percent') {
            $name .= $this->getValue() . '% off';
        } elseif ($this->getDiscountType() == 'fixed') {
            $name .= $this->displayCents($this->getValue()) . ' off';
        }

        return $name;
    }

    private function displayCents($priceInCents)
    {
        return '$' . number_format(($priceInCents / 100), 2);
    }

    public function getPrice(Pricing $pricing)
    {
        return $pricing->getPrice(
            $this->product,
            $this->quantity
        );
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
}
