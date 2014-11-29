<?php
namespace inklabs\kommerce\Entity\Payment;

use inklabs\kommerce\Entity as Entity;
use inklabs\kommerce\Entity\Accessor;

abstract class Payment
{
    use Accessor\Time;

    protected $id;
    protected $amount;

    protected $order;

    public function getId()
    {
        return $this->id;
    }

    public function getAmount()
    {
        return $this->amount;
    }

    public function addOrder(Entity\Order $order)
    {
        $this->order = $order;
    }

    public function getOrder()
    {
        return $this->order;
    }
}
