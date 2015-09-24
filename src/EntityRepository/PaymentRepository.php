<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity;

class PaymentRepository extends AbstractRepository implements PaymentRepositoryInterface
{
    public function save(Entity\AbstractPayment & $payment)
    {
        $this->saveEntity($payment);
    }

    public function create(Entity\AbstractPayment & $payment)
    {
        $this->createEntity($payment);
    }

    public function remove(Entity\AbstractPayment & $payment)
    {
        $this->removeEntity($payment);
    }

    public function persist(Entity\AbstractPayment & $payment)
    {
        $this->persistEntity($payment);
    }
}
