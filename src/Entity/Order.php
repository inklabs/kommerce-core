<?php
namespace inklabs\kommerce\Entity;

use inklabs\kommerce\Event\OrderShippedEvent;
use inklabs\kommerce\Lib\CartCalculatorInterface;
use inklabs\kommerce\Lib\ReferenceNumber\ReferenceNumberEntityInterface;
use Doctrine\Common\Collections\ArrayCollection;
use inklabs\kommerce\Lib\UuidInterface;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;

class Order implements IdEntityInterface, ReferenceNumberEntityInterface
{
    use TimeTrait, IdTrait, EventGeneratorTrait;

    /** @var string|null */
    protected $externalId;

    /** @var string|null */
    protected $referenceNumber;

    /** @var string|null */
    protected $discountNames;

    /** @var CartTotal */
    protected $total;

    /** @var OrderAddress */
    protected $shippingAddress;

    /** @var OrderAddress */
    protected $billingAddress;

    /** @var OrderStatusType */
    protected $status;

    /** @var User */
    protected $user;

    /** @var OrderItem[] */
    protected $orderItems;

    /** @var AbstractPayment[] */
    protected $payments;

    /** @var Coupon[] */
    protected $coupons;

    /** @var CartPriceRule[] */
    protected $cartPriceRules;

    /** @var ShipmentRate|null */
    protected $shipmentRate;

    /** @var TaxRate|null */
    protected $taxRate;

    /** @var Shipment[] */
    protected $shipments;

    /** @var int */
    protected $ip4;

    public function __construct(UuidInterface $id = null)
    {
        $this->setId($id);
        $this->setCreated();
        $this->orderItems = new ArrayCollection();
        $this->payments = new ArrayCollection();
        $this->coupons = new ArrayCollection();
        $this->cartPriceRules = new ArrayCollection();
        $this->shipments = new ArrayCollection();

        $this->setStatus(OrderStatusType::pending());
    }

    public static function fromCart(
        UuidInterface $orderId,
        User $user,
        Cart $cart,
        CartCalculatorInterface $cartCalculator,
        string $ip4
    ): Order {
        $order = new Order($orderId);
        $order->setIp4($ip4);

        foreach ($cart->getCartItems() as $item) {
            $orderItem = $item->getOrderItem($order, $cartCalculator->getPricing());
        }

        foreach ($cart->getCoupons() as $coupon) {
            $order->addCoupon($coupon);
        }

        $order->setUser($user);
        $order->setTaxRate($cart->getTaxRate());
        $order->setShipmentRate($cart->getShipmentRate());
        $order->setTotal($cart->getTotal($cartCalculator));

        return $order;
    }

    public static function loadValidatorMetadata(ClassMetadata $metadata): void
    {
        $metadata->addPropertyConstraint('externalId', new Assert\Length([
            'max' => 255,
        ]));

        $metadata->addPropertyConstraint('status', new Assert\Valid);

        $metadata->addPropertyConstraint('ip4', new Assert\NotBlank);
        $metadata->addPropertyConstraint('ip4', new Assert\GreaterThanOrEqual([
            'value' => 0,
        ]));

        $metadata->addPropertyConstraint('total', new Assert\Valid);
        $metadata->addPropertyConstraint('shippingAddress', new Assert\Valid);
        $metadata->addPropertyConstraint('billingAddress', new Assert\Valid);
        $metadata->addPropertyConstraint('orderItems', new Assert\Valid);
        $metadata->addPropertyConstraint('payments', new Assert\Valid);
        $metadata->addPropertyConstraint('shipments', new Assert\Valid);
    }

    public function getReferenceNumber(): ?string
    {
        return $this->referenceNumber;
    }

    public function setReferenceNumber(string $referenceNumber = null)
    {
        $this->referenceNumber = $referenceNumber;
    }

    public function addOrderItem(OrderItem $orderItem)
    {
        $this->orderItems->add($orderItem);
    }

    public function getExternalId(): ?string
    {
        return $this->externalId;
    }

    public function setExternalId(string $externalId)
    {
        $this->externalId = $externalId;
    }

    public function totalItems(): int
    {
        return count($this->orderItems);
    }

    public function totalQuantity(): int
    {
        $total = 0;

        foreach ($this->orderItems as $item) {
            $total += $item->getQuantity();
        }

        return $total;
    }

    public function setStatus(OrderStatusType $status)
    {
        $this->status = $status;
    }

    public function getStatus(): OrderStatusType
    {
        return $this->status;
    }

    public function getTotal(): CartTotal
    {
        return $this->total;
    }

    public function setTotal(CartTotal $total)
    {
        $this->total = $total;
        $this->setDiscountNames();
    }

    private function setDiscountNames()
    {
        $discountNames = [];
        foreach ($this->total->getCartPriceRules() as $cartPriceRule) {
            $this->cartPriceRules[] = $cartPriceRule;
            $discountNames[] = $cartPriceRule->getName();
        }

        foreach ($this->getCoupons() as $coupon) {
            $discountNames[] = $coupon->getName();
        }

        $this->discountNames = implode(', ', $discountNames);
    }

    public function setShippingAddress(OrderAddress $shippingAddress)
    {
        $this->shippingAddress = $shippingAddress;
    }

    public function getShippingAddress(): OrderAddress
    {
        return $this->shippingAddress;
    }

    public function setBillingAddress(OrderAddress $billingAddress)
    {
        $this->billingAddress = $billingAddress;
    }

    public function getBillingAddress(): OrderAddress
    {
        return $this->billingAddress;
    }

    /**
     * @return OrderItem[]
     */
    public function getOrderItems()
    {
        return $this->orderItems;
    }

    public function getOrderItem(int $orderItemIndex): OrderItem
    {
        return $this->orderItems[$orderItemIndex];
    }

    public function addPayment(AbstractPayment $payment)
    {
        $payment->setOrder($this);
        $this->payments[] = $payment;
    }

    /**
     * @return AbstractPayment[]
     */
    public function getPayments()
    {
        return $this->payments;
    }

    public function addCoupon(Coupon $coupon)
    {
        $this->coupons[] = $coupon;
    }

    /**
     * @return Coupon[]
     */
    public function getCoupons()
    {
        return $this->coupons;
    }


    public function setUser(User $user)
    {
        $this->user = $user;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function getShipmentRate(): ?ShipmentRate
    {
        return $this->shipmentRate;
    }

    public function setShipmentRate(ShipmentRate $shipmentRate = null)
    {
        $this->shipmentRate = $shipmentRate;
    }

    public function getTaxRate(): ?TaxRate
    {
        return $this->taxRate;
    }

    public function setTaxRate(TaxRate $taxRate = null)
    {
        $this->taxRate = $taxRate;
    }

    /**
     * @return Product[]
     */
    public function getProducts()
    {
        $products = [];
        foreach ($this->getOrderItems() as $orderItem) {
            $product = $orderItem->getProduct();

            if ($product !== null) {
                $products[] = $product;
            }
        }

        return $products;
    }

    public function addShipment(Shipment $shipment)
    {
        $shipment->setOrder($this);
        $this->shipments->add($shipment);
        $this->setOrderShippedStatus();

        $this->raise(
            new OrderShippedEvent($this->getId(), $shipment->getId())
        );
    }

    /**
     * @return Shipment[]
     */
    public function getShipments()
    {
        return $this->shipments;
    }

    private function setOrderShippedStatus()
    {
        if ($this->isFullyShipped()) {
            $this->setStatus(OrderStatusType::shipped());
        } else {
            $this->setStatus(OrderStatusType::partiallyShipped());
        }
    }

    private function isFullyShipped(): bool
    {
        foreach ($this->orderItems as $orderItem) {
            if (! $this->isOrderItemFullyShipped($orderItem)) {
                return false;
            }
        }

        return true;
    }

    private function isOrderItemFullyShipped(OrderItem $orderItem): bool
    {
        foreach ($this->getShipments() as $shipment) {
            if ($orderItem->isShipmentFullyShipped($shipment)) {
                return true;
            }
        }

        return false;
    }

    public function setIp4(?string $ip4)
    {
        $this->ip4 = ip2long($ip4);
    }

    public function getIp4(): string
    {
        return long2ip($this->ip4);
    }

    public function getDiscountNames(): ?string
    {
        return $this->discountNames;
    }

    /**
     * @return ArrayCollection|CartPriceRule[]
     */
    public function getCartPriceRules()
    {
        return $this->cartPriceRules;
    }
}
