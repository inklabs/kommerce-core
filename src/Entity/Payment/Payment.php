<?php
namespace inklabs\kommerce\Entity\Payment;

use inklabs\kommerce\Entity;
use inklabs\kommerce\Entity\Accessor;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;

abstract class Payment implements Entity\EntityInterface
{
    use Accessor\Time, Accessor\Id;

    /** @var int */
    protected $amount;

    /** @var Entity\Order */
    protected $order;

    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraint('amount', new Assert\NotNull);
        $metadata->addPropertyConstraint('amount', new Assert\Range([
            'min' => 0,
            'max' => 4294967295,
        ]));
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

    public function getOrder()
    {
        return $this->order;
    }

    /**
     * @return View\Payment\Payment
     */
    abstract public function getView();
}
