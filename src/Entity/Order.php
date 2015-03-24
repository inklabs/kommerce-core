<?php
namespace inklabs\kommerce\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use inklabs\kommerce\Entity\Payment as Payment;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;

class Order
{
    use Accessor\Time;

    protected $id;

    /* @var CartTotal */
    protected $total;

    /* @var OrderAddress */
    protected $shippingAddress;

    /* @var OrderAddress */
    protected $billingAddress;

    /* @var int */
    protected $status;
    const STATUS_PENDING    = 0;
    const STATUS_PROCESSING = 1;
    const STATUS_SHIPPED    = 2;
    const STATUS_COMPLETE   = 3;
    const STATUS_CANCELED   = 4;

    /* @var User */
    protected $user;

    /* @var OrderItem[] */
    protected $items;

    /* @var Payment\Payment[] */
    protected $payments;

    /* @var Coupon[] */
    protected $coupons;

    public function __construct(array $orderItems, CartTotal $total)
    {
        $this->setCreated();
        $this->items = new ArrayCollection();
        $this->payments = new ArrayCollection();
        $this->coupons = new ArrayCollection();

        $this->setStatus(self::STATUS_PENDING);
        $this->setTotal($total);

        foreach ($orderItems as $orderItem) {
            $this->addItem($orderItem);
        }
    }

    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraint('status', new Assert\Choice([
            'choices' => array_keys(static::getStatusMapping()),
            'message' => 'The status is not a valid choice',
        ]));

        $metadata->addPropertyConstraint('total', new Assert\Valid);
        $metadata->addPropertyConstraint('shippingAddress', new Assert\Valid);
        $metadata->addPropertyConstraint('billingAddress', new Assert\Valid);
        $metadata->addPropertyConstraint('items', new Assert\Valid);
        $metadata->addPropertyConstraint('payments', new Assert\Valid);
    }

    /**
     * @return int
     */
    private function addItem(OrderItem $orderItem)
    {
        $orderItem->setOrder($this);
        $this->items[] = $orderItem;

        $itemId = $this->getLastItemId();
        return $itemId;
    }

    /**
     * @return int
     */
    private function getLastItemId()
    {
        end($this->items);
        return key($this->items);
    }

    public function totalItems()
    {
        return count($this->items);
    }

    public function totalQuantity()
    {
        $total = 0;

        foreach ($this->items as $item) {
            $total += $item->getQuantity();
        }

        return $total;
    }

    public function setId($id)
    {
        $this->id = (int) $id;
    }

    public function getId()
    {
        return $this->id;
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

    private function setTotal(CartTotal $total)
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

    public function getItems()
    {
        return $this->items;
    }

    public function getItem($itemId)
    {
        return $this->items[$itemId];
    }

    public function addPayment(Payment\Payment $payment)
    {
        $payment->addOrder($this);
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

    public function getView()
    {
        return new View\Order($this);
    }
}
