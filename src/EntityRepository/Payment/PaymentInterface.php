<?php
namespace inklabs\kommerce\EntityRepository\Payment;

use inklabs\kommerce\Entity;

interface PaymentInterface
{
    /**
     * @param int $id
     * @return Entity\Payment\Payment
     */
    public function find($id);

    /**
     * @param Entity\Payment\Payment $payment
     */
    public function create(Entity\Payment\Payment & $payment);

    /**
     * @param Entity\Payment\Payment $payment
     */
    public function save(Entity\Payment\Payment & $payment);

    /**
     * @param Entity\Payment\Payment $payment
     */
    public function persist(Entity\Payment\Payment & $payment);

    public function flush();
}
