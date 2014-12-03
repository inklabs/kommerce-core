<?php
namespace inklabs\kommerce\Entity\Payment;

use inklabs\kommerce\Entity as Entity;
use inklabs\kommerce\Entity\Accessor;

abstract class Payment
{
    use Accessor\Time;

    protected $id;
    protected $amount;

    /* @var Entity\Order */
    protected $order;

    public function setId($id)
    {
        $this->id = (int) $id;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setAmount($amount)
    {
        $this->amount = (int) $amount;
    }

    public function getAmount()
    {
        return $this->amount;
    }

    public function addOrder(Entity\Order $order)
    {
        $this->order = $order;
    }

    /**
     * @return Entity\Order
     */
    public function getOrder()
    {
        return $this->order;
    }
}
