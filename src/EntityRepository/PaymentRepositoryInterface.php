<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity;

interface PaymentRepositoryInterface
{
    public function save(Entity\AbstractPayment & $payment);
    public function create(Entity\AbstractPayment & $payment);
    public function remove(Entity\AbstractPayment & $payment);
    public function persist(Entity\AbstractPayment & $payment);
    public function flush();

    /**
     * @param int $id
     * @return Entity\AbstractPayment
     */
    public function find($id);
}
