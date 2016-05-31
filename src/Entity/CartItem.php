<?php
namespace inklabs\kommerce\Entity;

use inklabs\kommerce\EntityDTO\Builder\CartItemDTOBuilder;
use Doctrine\Common\Collections\ArrayCollection;
use inklabs\kommerce\Exception\AttachmentException;
use inklabs\kommerce\Lib\PricingInterface;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;

class CartItem implements EntityInterface, ValidationInterface, EnabledAttachmentInterface
{
    use TimeTrait, IdTrait;

    /** @var int */
    protected $quantity;

    /** @var Product */
    protected $product;

    /** @var Cart */
    protected $cart;

    /** @var CartItemOptionProduct[] */
    protected $cartItemOptionProducts;

    /** @var CartItemOptionValue[] */
    protected $cartItemOptionValues;

    /** @var CartItemTextOptionValue[] */
    protected $cartItemTextOptionValues;

    /** @var Attachment[] */
    protected $attachments;

    public function __construct()
    {
        $this->setId();
        $this->setCreated();
        $this->cartItemOptionProducts = new ArrayCollection;
        $this->cartItemOptionValues = new ArrayCollection;
        $this->cartItemTextOptionValues = new ArrayCollection;
        $this->attachments = new ArrayCollection;
    }

    public function __clone()
    {
        $this->cloneCartItemOptionProducts();
        $this->cloneCartItemOptionValues();
        $this->cloneCartItemTextOptionValues();
    }

    private function cloneCartItemOptionProducts()
    {
        $cartItemOptionProducts = $this->getCartItemOptionProducts();

        $this->cartItemOptionProducts = new ArrayCollection;
        foreach ($cartItemOptionProducts as $cartItemOptionProduct) {
            $this->addCartItemOptionProduct(clone $cartItemOptionProduct);
        }
    }

    private function cloneCartItemOptionValues()
    {
        $cartItemOptionValues = $this->getCartItemOptionValues();

        $this->cartItemOptionValues = new ArrayCollection;
        foreach ($cartItemOptionValues as $cartItemOptionValue) {
            $this->addCartItemOptionValue(clone $cartItemOptionValue);
        }
    }

    private function cloneCartItemTextOptionValues()
    {
        $cartItemTextOptionValues = $this->getCartItemTextOptionValues();

        $this->cartItemTextOptionValues = new ArrayCollection;
        foreach ($cartItemTextOptionValues as $cartItemTextOptionValue) {
            $this->addCartItemTextOptionValue(clone $cartItemTextOptionValue);
        }
    }

    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraint('quantity', new Assert\NotNull);
        $metadata->addPropertyConstraint('quantity', new Assert\Range([
            'min' => 0,
            'max' => 65535,
        ]));
    }

    public function getCart()
    {
        return $this->cart;
    }

    public function setCart(Cart $cart)
    {
        $this->cart = $cart;
    }

    public function getProduct()
    {
        return $this->product;
    }

    public function setProduct(Product $product)
    {
        $this->product = $product;
    }

    public function getQuantity()
    {
        return $this->quantity;
    }

    public function setQuantity($quantity)
    {
        $this->quantity = (int) $quantity;
    }

    /**
     * @return CartItemOptionProduct[]
     */
    public function getCartItemOptionProducts()
    {
        return $this->cartItemOptionProducts;
    }

    public function addCartItemOptionProduct(CartItemOptionProduct $cartItemOptionProduct)
    {
        $cartItemOptionProduct->setCartItem($this);
        $this->cartItemOptionProducts[] = $cartItemOptionProduct;
    }

    /**
     * @return CartItemOptionValue[]
     */
    public function getCartItemOptionValues()
    {
        return $this->cartItemOptionValues;
    }

    public function addCartItemOptionValue(CartItemOptionValue $cartItemOptionValue)
    {
        $cartItemOptionValue->setCartItem($this);
        $this->cartItemOptionValues[] = $cartItemOptionValue;
    }

    /**
     * @return CartItemTextOptionValue[]
     */
    public function getCartItemTextOptionValues()
    {
        return $this->cartItemTextOptionValues;
    }

    public function addCartItemTextOptionValue(CartItemTextOptionValue $cartItemTextOptionValue)
    {
        $cartItemTextOptionValue->setCartItem($this);
        $this->cartItemTextOptionValues[] = $cartItemTextOptionValue;
    }

    public function getPrice(PricingInterface $pricing)
    {
        $price = $this->getProduct()->getPrice(
            $pricing,
            $this->getQuantity()
        );

        foreach ($this->getCartItemOptionProducts() as $cartItemOptionProduct) {
            $optionPrice = $cartItemOptionProduct->getPrice(
                $pricing,
                $this->getQuantity()
            );

            $price = Price::add($price, $optionPrice);
        }

        foreach ($this->getCartItemOptionValues() as $cartItemOptionValue) {
            $optionPrice = $cartItemOptionValue->getPrice($this->getQuantity());

            $price = Price::add($price, $optionPrice);
        }

        // No price for cartItemTextOptionValues

        return $price;
    }

    public function getFullSku()
    {
        $fullSku = [];
        $fullSku[] = $this->getProduct()->getSku();

        foreach ($this->getCartItemOptionProducts() as $cartItemOptionProduct) {
            $fullSku[] = $cartItemOptionProduct->getSku();
        }

        foreach ($this->getCartItemOptionValues() as $cartItemOptionValue) {
            $fullSku[] = $cartItemOptionValue->getSku();
        }

        // No sku for cartItemTextOptionValues

        return implode('-', $fullSku);
    }

    public function getShippingWeight()
    {
        $shippingWeight = $this->getProduct()->getShippingWeight();

        foreach ($this->getCartItemOptionProducts() as $cartItemOptionProduct) {
            $shippingWeight += $cartItemOptionProduct->getShippingWeight();
        }

        foreach ($this->getCartItemOptionValues() as $cartItemOptionValue) {
            $shippingWeight += $cartItemOptionValue->getShippingWeight();
        }

        // No shippingWeight for cartItemTextOptionValues

        $quantityShippingWeight = $shippingWeight * $this->getQuantity();

        return $quantityShippingWeight;
    }

    public function getOrderItem(PricingInterface $pricing)
    {
        $orderItem = new OrderItem;
        $orderItem->setProduct($this->getProduct());
        $orderItem->setQuantity($this->getQuantity());
        $orderItem->setPrice($this->getPrice($pricing));

        foreach ($this->getCartItemOptionProducts() as $cartItemOptionProduct) {
            $orderItemOptionProduct = new OrderItemOptionProduct;
            $orderItemOptionProduct->setOptionProduct($cartItemOptionProduct->getOptionProduct());
            $orderItem->addOrderItemOptionProduct($orderItemOptionProduct);
        }

        foreach ($this->getCartItemOptionValues() as $cartItemTextOptionValue) {
            $orderItemOptionValue = new OrderItemOptionValue;
            $orderItemOptionValue->setOptionValue($cartItemTextOptionValue->getOptionValue());
            $orderItem->addOrderItemOptionValue($orderItemOptionValue);
        }

        foreach ($this->getCartItemTextOptionValues() as $cartItemTextOptionValue) {
            $orderItemTextOptionValue = new OrderItemTextOptionValue;
            $orderItemTextOptionValue->setTextOption($cartItemTextOptionValue->getTextOption());
            $orderItemTextOptionValue->setTextOptionValue($cartItemTextOptionValue->getTextOptionValue());
            $orderItem->addOrderItemTextOptionValue($orderItemTextOptionValue);
        }

        return $orderItem;
    }

    public function getAttachments()
    {
        return $this->attachments;
    }

    public function addAttachment(Attachment $attachment)
    {
        if (! $this->areAttachmentsEnabled()) {
            throw AttachmentException::notAllowed();
        }

        $this->attachments->add($attachment);
    }

    public function removeAttachment(Attachment $attachment)
    {
        $this->attachments->removeElement($attachment);
    }

    public function areAttachmentsEnabled()
    {
        return $this->product->areAttachmentsEnabled();
    }
}
