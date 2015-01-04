<?php
namespace inklabs\kommerce\Entity;

use inklabs\kommerce\Service\Pricing;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;

class OrderItem
{
    use Accessor\Time;

    protected $id;
    protected $quantity;

    /* @var Price */
    protected $price;

    /* @var Product */
    protected $product;

    /* @var Order */
    protected $order;

    /* @var CatalogPromotion[] */
    protected $catalogPromotions;

    /* @var ProductQuantityDiscount */
    protected $productQuantityDiscount;

    /* Flattened Columns */
    protected $productSku;
    protected $productName;
    protected $discountNames;

    public function __construct(CartItem $cartItem, Pricing $pricing)
    {
        $this->setCreated();
        $this->catalogPromotions = new ArrayCollection;
        $this->quantity = $cartItem->getQuantity();

        $this->setProduct($cartItem->getProduct());
        $this->setPrice($cartItem->getPrice($pricing));
    }

    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraint('quantity', new Assert\NotNull);
        $metadata->addPropertyConstraint('quantity', new Assert\Range([
            'min' => 0,
            'max' => 65535,
        ]));

        $metadata->addPropertyConstraint('productSku', new Assert\Length([
            'max' => 64,
        ]));

        $metadata->addPropertyConstraint('productName', new Assert\NotBlank);
        $metadata->addPropertyConstraint('productName', new Assert\Length([
            'max' => 255,
        ]));

        $metadata->addPropertyConstraint('discountNames', new Assert\Length([
            'max' => 255,
        ]));

        $metadata->addPropertyConstraint('price', new Assert\Valid);
    }

    private function setProduct(Product $product)
    {
        $this->product = $product;

        $this->productSku = $product->getSku();
        $this->productName = $product->getName();
    }

    public function getProduct()
    {
        return $this->product;
    }

    public function getQuantity()
    {
        return $this->quantity;
    }

    public function getProductSku()
    {
        return $this->productSku;
    }

    public function getProductName()
    {
        return $this->productName;
    }

    private function setPrice(Price $price)
    {
        $this->price = $price;

        $discountNames = [];
        foreach ($price->getCatalogPromotions() as $catalogPromotion) {
            $this->catalogPromotions[] = $catalogPromotion;
            $discountNames[] = $catalogPromotion->getName();
        }

        $this->productQuantityDiscount = $price->getProductQuantityDiscount();

        if ($this->productQuantityDiscount !== null) {
            $discountNames[] = $this->productQuantityDiscount->getName();
        }

        $this->discountNames = implode(', ', $discountNames);
    }

    public function getId()
    {
        return $this->id;
    }

    public function getPrice()
    {
        return $this->price;
    }

    public function getDiscountNames()
    {
        return $this->discountNames;
    }

    public function setOrder(Order $order)
    {
        $this->order = $order;
    }

    public function getCatalogPromotions()
    {
        return $this->catalogPromotions;
    }

    public function getProductQuantityDiscount()
    {
        return $this->productQuantityDiscount;
    }

    public function getView()
    {
        return new View\OrderItem($this);
    }
}
