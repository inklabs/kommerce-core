<?php
namespace inklabs\kommerce\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use inklabs\kommerce\Exception\AttachmentException;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;

class OrderItem implements IdEntityInterface, EnabledAttachmentInterface
{
    use TimeTrait, IdTrait;

    /** @var int */
    protected $quantity;

    /** @var string|null */
    protected $sku;

    /** @var string */
    protected $name;

    /** @var string|null */
    protected $discountNames;

    /** @var Price */
    protected $price;

    /** @var Product|null */
    protected $product;

    /** @var Order */
    protected $order;

    /** @var OrderItemOptionProduct[] */
    protected $orderItemOptionProducts;

    /** @var OrderItemOptionValue[] */
    protected $orderItemOptionValues;

    /** @var OrderItemTextOptionValue[] */
    protected $orderItemTextOptionValues;

    /** @var CatalogPromotion[] */
    protected $catalogPromotions;

    /** @var ProductQuantityDiscount[] */
    protected $productQuantityDiscounts;

    /** @var Attachment[] */
    protected $attachments;

    public function __construct(Order $order)
    {
        $this->setId();
        $this->setCreated();
        $this->catalogPromotions = new ArrayCollection();
        $this->productQuantityDiscounts = new ArrayCollection();
        $this->orderItemOptionProducts = new ArrayCollection();
        $this->orderItemOptionValues = new ArrayCollection();
        $this->orderItemTextOptionValues = new ArrayCollection();
        $this->attachments = new ArrayCollection();

        $this->order = $order;
        $order->addOrderItem($this);
    }

    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraint('quantity', new Assert\NotNull);
        $metadata->addPropertyConstraint('quantity', new Assert\Range([
            'min' => 0,
            'max' => 65535,
        ]));

        $metadata->addPropertyConstraint('sku', new Assert\Length([
            'max' => 64,
        ]));

        $metadata->addPropertyConstraint('name', new Assert\NotBlank);
        $metadata->addPropertyConstraint('name', new Assert\Length([
            'max' => 255,
        ]));

        $metadata->addPropertyConstraint('discountNames', new Assert\Length([
            'max' => 255,
        ]));

        $metadata->addPropertyConstraint('price', new Assert\Valid);
    }

    public function setProduct(Product $product)
    {
        $this->product = $product;

        $this->setName($product->getName());
        $this->setSku();
    }

    public function getProduct(): ?Product
    {
        return $this->product;
    }

    /**
     * @return OrderItemOptionProduct[]
     */
    public function getOrderItemOptionProducts()
    {
        return $this->orderItemOptionProducts;
    }

    public function addOrderItemOptionProduct(OrderItemOptionProduct $orderItemOptionProduct)
    {
        $orderItemOptionProduct->setOrderItem($this);
        $this->orderItemOptionProducts[] = $orderItemOptionProduct;

        $this->setSku();
    }

    /**
     * @return OrderItemOptionValue[]
     */
    public function getOrderItemOptionValues()
    {
        return $this->orderItemOptionValues;
    }

    public function addOrderItemOptionValue(OrderItemOptionValue $orderItemOptionValue)
    {
        $orderItemOptionValue->setOrderItem($this);
        $this->orderItemOptionValues[] = $orderItemOptionValue;

        $this->setSku();
    }

    /**
     * @return OrderItemTextOptionValue[]
     */
    public function getOrderItemTextOptionValues()
    {
        return $this->orderItemTextOptionValues;
    }

    public function addOrderItemTextOptionValue(OrderItemTextOptionValue $orderItemTextOptionValue)
    {
        $orderItemTextOptionValue->setOrderItem($this);
        $this->orderItemTextOptionValues[] = $orderItemTextOptionValue;
    }

    public function setQuantity(int $quantity)
    {
        $this->quantity = $quantity;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    private function setSku()
    {
        $this->sku = $this->getFullSku();
    }

    private function getFullSku(): string
    {
        $fullSku = [];

        if ($this->product !== null) {
            $sku = $this->product->getSku();

            if ($sku !== null) {
                $fullSku[] = $sku;
            }
        }

        foreach ($this->getOrderItemOptionProducts() as $orderItemOptionProduct) {
            $sku = $orderItemOptionProduct->getSku();

            if ($sku !== null) {
                $fullSku[] = $sku;
            }
        }

        foreach ($this->getOrderItemOptionValues() as $orderItemOptionValue) {
            $sku = $orderItemOptionValue->getSku();

            if ($sku !== null) {
                $fullSku[] = $sku;
            }
        }

        return implode('-', $fullSku);
    }

    public function getSku(): ?string
    {
        return $this->sku;
    }

    public function setName(string $name)
    {
        $this->name = $name;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setPrice(Price $price)
    {
        $this->price = $price;
        $this->setDiscountNames();
    }

    private function setDiscountNames()
    {
        $discountNames = [];
        foreach ($this->price->getCatalogPromotions() as $catalogPromotion) {
            $this->addCatalogPromotion($catalogPromotion);
            $discountNames[] = $catalogPromotion->getName();
        }

        foreach ($this->price->getProductQuantityDiscounts() as $productQuantityDiscount) {
            $this->addProductQuantityDiscount($productQuantityDiscount);
            $discountNames[] = $productQuantityDiscount->getName();
        }

        $this->discountNames = implode(', ', $discountNames);
    }

    public function getPrice(): Price
    {
        return $this->price;
    }

    public function getDiscountNames(): ?string
    {
        return $this->discountNames;
    }

    public function getOrder(): Order
    {
        return $this->order;
    }

    public function addCatalogPromotion(CatalogPromotion $catalogPromotion)
    {
        $this->catalogPromotions[] = $catalogPromotion;
    }

    /**
     * @return CatalogPromotion[]
     */
    public function getCatalogPromotions()
    {
        return $this->catalogPromotions;
    }

    public function addProductQuantityDiscount(ProductQuantityDiscount $productQuantityDiscount)
    {
        $this->productQuantityDiscounts[] = $productQuantityDiscount;
    }

    /**
     * @return ProductQuantityDiscount[]
     */
    public function getProductQuantityDiscounts()
    {
        return $this->productQuantityDiscounts;
    }

    /**
     * TODO: Flatten this value
     *
     * @param int|null $quantity
     * @return int shipping weight in ounces
     */
    public function getQuantityShippingWeight(int $quantity = null): int
    {
        if ($quantity === null) {
            $quantity = $this->quantity;
        }

        return $this->getShippingWeight() * (int) $quantity;
    }

    /**
     * @return int shipping weight in ounces
     */
    public function getShippingWeight(): int
    {
        $shippingWeight = $this->product->getShippingWeight();

        foreach ($this->orderItemOptionProducts as $orderItemOptionValue) {
            $shippingWeight += $orderItemOptionValue->getOptionProduct()->getShippingWeight();
        }

        foreach ($this->orderItemOptionValues as $orderItemOptionValue) {
            $shippingWeight += $orderItemOptionValue->getOptionValue()->getShippingWeight();
        }

        // No shippingWeight for orderItemTextOptionValues

        return $shippingWeight;
    }

    public function isShipmentFullyShipped(Shipment $shipment): bool
    {
        $shipmentItem = $shipment->getShipmentItemForOrderItem($this);

        if ($shipmentItem === null) {
            return false;
        }

        if ($shipmentItem->getQuantityToShip() < $this->quantity) {
            return false;
        }

        return true;
    }

    /**
     * @return Attachment[]
     */
    public function getAttachments()
    {
        return $this->attachments->toArray();
    }

    public function addAttachment(Attachment $attachment)
    {
        if (! $this->areAttachmentsEnabled()) {
            throw AttachmentException::notAllowed();
        }

        $attachment->addOrderItem($this);
        $this->attachments->add($attachment);
    }

    public function removeAttachment(Attachment $attachment)
    {
        $this->attachments->removeElement($attachment);
    }

    public function areAttachmentsEnabled(): bool
    {
        if ($this->product !== null) {
            return $this->product->areAttachmentsEnabled();
        }

        return false;
    }
}
