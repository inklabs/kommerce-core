<?php
namespace inklabs\kommerce\Entity;

use inklabs\kommerce\EntityDTO\Builder\ProductQuantityDiscountDTOBuilder;
use inklabs\kommerce\View;
use inklabs\kommerce\Lib;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;

class ProductQuantityDiscount extends AbstractPromotion
{
    protected $customerGroup;
    protected $flagApplyCatalogPromotions;
    protected $quantity;

    /** @var Product */
    protected $product;

    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        parent::loadValidatorMetadata($metadata);

        $metadata->addPropertyConstraint('quantity', new Assert\NotNull);
        $metadata->addPropertyConstraint('quantity', new Assert\Range([
            'min' => 0,
            'max' => 65535,
        ]));
    }

    public function setName($name)
    {
        throw new \Exception('Unable to set name.');
    }

    public function getName()
    {
        $name = 'Buy ' . $this->getQuantity() . ' or more for ';

        if ($this->getType() === AbstractPromotion::TYPE_EXACT) {
            $name .= $this->displayCents($this->getValue()) . ' each';
        } elseif ($this->getType() === AbstractPromotion::TYPE_PERCENT) {
            $name .= $this->getValue() . '% off';
        } elseif ($this->getType() === AbstractPromotion::TYPE_FIXED) {
            $name .= $this->displayCents($this->getValue()) . ' off';
        }

        return $name;
    }

    private function displayCents($priceInCents)
    {
        return '$' . number_format(($priceInCents / 100), 2);
    }

    public function getPrice(Lib\PricingInterface $pricing)
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

    public function getView()
    {
        return new View\ProductQuantityDiscount($this);
    }

    /**
     * @return ProductQuantityDiscountDTOBuilder
     */
    public function getDTOBuilder()
    {
        return new ProductQuantityDiscountDTOBuilder($this);
    }
}
