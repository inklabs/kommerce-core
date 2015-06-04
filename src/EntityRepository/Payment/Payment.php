<?php
namespace inklabs\kommerce\EntityRepository\Payment;

use inklabs\kommerce\EntityRepository\AbstractEntityRepository;
use inklabs\kommerce\Entity;

class Payment extends AbstractEntityRepository implements PaymentInterface
{
    public function save(Entity\Payment\Payment & $payment)
    {
        $this->saveEntity($payment);
    }

    public function create(Entity\Payment\Payment & $payment)
    {
        $this->createEntity($payment);
    }

    public function remove(Entity\Payment\Payment & $payment)
    {
        $this->removeEntity($payment);
    }

    public function persist(Entity\Payment\Payment & $payment)
    {
        $this->persistEntity($payment);
    }
}
