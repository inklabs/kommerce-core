<?php
namespace inklabs\kommerce\Entity;

use inklabs\kommerce\EntityDTO\Builder\OrderDTOBuilder;
use inklabs\kommerce\Event\OrderCreatedFromCartEvent;
use inklabs\kommerce\Lib\CartCalculatorInterface;
use inklabs\kommerce\Lib\ReferenceNumber;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;

class Order implements EntityInterface, ValidationInterface, ReferenceNumber\EntityInterface
{
    use TimeTrait, IdTrait, EventGeneratorTrait;

    /** @var string */
    protected $externalId;

    /** @var string */
    protected $referenceNumber;

    /** @var CartTotal */
    protected $total;

    /** @var OrderAddress */
    protected $shippingAddress;

    /** @var OrderAddress */
    protected $billingAddress;

    /** @var int */
    protected $status;
    const STATUS_PENDING    = 0;
    const STATUS_PROCESSING = 1;
    const STATUS_SHIPPED    = 2;
    const STATUS_COMPLETE   = 3;
    const STATUS_CANCELED   = 4;

    /** @var User */
    protected $user;

    /** @var OrderItem[] */
    protected $orderItems;

    /** @var AbstractPayment[] */
    protected $payments;

    /** @var Coupon[] */
    protected $coupons;

    /** @var ShippingRate */
    protected $shippingRate;

    /** @var TaxRate */
    protected $taxRate;

    public function __construct()
    {
        $this->setCreated();
        $this->orderItems = new ArrayCollection;
        $this->payments = new ArrayCollection;
        $this->coupons = new ArrayCollection;

        $this->setStatus(self::STATUS_PENDING);
    }

    public static function fromCart(Cart $cart, CartCalculatorInterface $cartCalculator)
    {
        $order = new static;
        $order->setTotal($cart->getTotal($cartCalculator));

        foreach ($cart->getCartItems() as $item) {
            $order->addOrderItem($item->getOrderItem($cartCalculator->getPricing()));
        }

        foreach ($cart->getCoupons() as $coupon) {
            $order->addCoupon($coupon);
        }

        $order->setUser($cart->getUser());
        $order->setShippingRate($cart->getShippingRate());
        $order->setTaxRate($cart->getTaxRate());

        $order->raise(
            new OrderCreatedFromCartEvent($order)
        );

        return $order;
    }

    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraint('externalId', new Assert\Length([
            'max' => 255,
        ]));

        $metadata->addPropertyConstraint('status', new Assert\Choice([
            'choices' => array_keys(static::getStatusMapping()),
            'message' => 'The status is not a valid choice',
        ]));

        $metadata->addPropertyConstraint('total', new Assert\Valid);
        $metadata->addPropertyConstraint('shippingAddress', new Assert\Valid);
        $metadata->addPropertyConstraint('billingAddress', new Assert\Valid);
        $metadata->addPropertyConstraint('orderItems', new Assert\Valid);
        $metadata->addPropertyConstraint('payments', new Assert\Valid);
    }

    public function getReferenceId()
    {
        return $this->getId();
    }

    public function getReferenceNumber()
    {
        return $this->referenceNumber;
    }

    public function setReferenceNumber($referenceNumber = null)
    {
        $this->referenceNumber = $referenceNumber;
    }

    /**
     * @param OrderItem $orderItem
     * @return int
     */
    public function addOrderItem(OrderItem $orderItem)
    {
        $orderItem->setOrder($this);
        $this->orderItems[] = $orderItem;

        $orderItemIndex = $this->getLastOrderItemIndex();
        return $orderItemIndex;
    }

    /**
     * @return int
     */
    private function getLastOrderItemIndex()
    {
        end($this->orderItems);
        return key($this->orderItems);
    }

    public function getExternalId()
    {
        return $this->externalId;
    }

    /**
     * @param string $externalId
     */
    public function setExternalId($externalId)
    {
        $this->externalId = (string) $externalId;
    }

    public function totalItems()
    {
        return count($this->orderItems);
    }

    public function totalQuantity()
    {
        $total = 0;

        foreach ($this->orderItems as $item) {
            $total += $item->getQuantity();
        }

        return $total;
    }

    public function setStatus($status)
    {
        $this->status = (int) $status;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public static function getStatusMapping()
    {
        return [
            static::STATUS_PENDING => 'Pending',
            static::STATUS_PROCESSING => 'Processing',
            static::STATUS_SHIPPED => 'Shipped',
            static::STATUS_COMPLETE => 'Complete',
            static::STATUS_CANCELED => 'Canceled',
        ];
    }

    public function getStatusText()
    {
        return $this->getStatusMapping()[$this->status];
    }

    public function setTotal(CartTotal $total)
    {
        $this->total = $total;
    }

    public function getTotal()
    {
        return $this->total;
    }

    public function setShippingAddress(OrderAddress $shippingAddress)
    {
        $this->shippingAddress = $shippingAddress;
    }

    public function getShippingAddress()
    {
        return $this->shippingAddress;
    }

    public function setBillingAddress(OrderAddress $billingAddress)
    {
        $this->billingAddress = $billingAddress;
    }

    public function getBillingAddress()
    {
        return $this->billingAddress;
    }

    public function getOrderItems()
    {
        return $this->orderItems;
    }

    public function getOrderItem($orderItemIndex)
    {
        return $this->orderItems[$orderItemIndex];
    }

    public function addPayment(AbstractPayment $payment)
    {
        $payment->setOrder($this);
        $this->payments[] = $payment;
    }

    public function getPayments()
    {
        return $this->payments;
    }

    public function addCoupon(Coupon $coupon)
    {
        $this->coupons[] = $coupon;
    }

    public function getCoupons()
    {
        return $this->coupons;
    }


    public function setUser(User $user)
    {
        $this->user = $user;
    }

    public function getUser()
    {
        return $this->user;
    }

    public function getShippingRate()
    {
        return $this->shippingRate;
    }

    public function setShippingRate(ShippingRate $shippingRate = null)
    {
        $this->shippingRate = $shippingRate;
    }

    public function getTaxRate()
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

    public function getDTOBuilder()
    {
        return new OrderDTOBuilder($this);
    }
}
