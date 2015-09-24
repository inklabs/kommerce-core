<?php
namespace inklabs\kommerce\EntityRepository\Payment;

use inklabs\kommerce\Entity;

interface PaymentRepositoryInterface
{
    public function save(Entity\Payment\AbstractPayment & $payment);
    public function create(Entity\Payment\AbstractPayment & $payment);
    public function remove(Entity\Payment\AbstractPayment & $payment);
    public function persist(Entity\Payment\AbstractPayment & $payment);
    public function flush();

    /**
     * @param int $id
     * @return Entity\Payment\AbstractPayment
     */
    public function find($id);
}
