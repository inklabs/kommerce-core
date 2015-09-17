<?php
namespace inklabs\kommerce\EntityRepository\Payment;

use inklabs\kommerce\Entity;

interface PaymentRepositoryInterface
{
    public function save(Entity\Payment\Payment & $payment);
    public function create(Entity\Payment\Payment & $payment);
    public function remove(Entity\Payment\Payment & $payment);
    public function persist(Entity\Payment\Payment & $payment);
    public function flush();

    /**
     * @param int $id
     * @return Entity\Payment\Payment
     */
    public function find($id);
}
