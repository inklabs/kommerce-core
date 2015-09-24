<?php
namespace inklabs\kommerce\EntityRepository\Payment;

use inklabs\kommerce\EntityRepository\AbstractRepository;
use inklabs\kommerce\Entity;

class PaymentRepository extends AbstractRepository implements PaymentRepositoryInterface
{
    public function save(Entity\Payment\AbstractPayment & $payment)
    {
        $this->saveEntity($payment);
    }

    public function create(Entity\Payment\AbstractPayment & $payment)
    {
        $this->createEntity($payment);
    }

    public function remove(Entity\Payment\AbstractPayment & $payment)
    {
        $this->removeEntity($payment);
    }

    public function persist(Entity\Payment\AbstractPayment & $payment)
    {
        $this->persistEntity($payment);
    }
}
