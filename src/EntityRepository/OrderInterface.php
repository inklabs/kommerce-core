<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity;
use inklabs\kommerce\Lib;
use inklabs\kommerce\Lib\ReferenceNumber;

interface OrderInterface extends ReferenceNumber\RepositoryInterface
{
    /**
     * @param int $id
     * @return Entity\Order
     */
    public function find($id);

    /**
     * @param Entity\Pagination $pagination
     * @return Entity\Order[]
     */
    public function getLatestOrders(Entity\Pagination & $pagination = null);

    /**
     * @param Entity\Order $order
     */
    public function save(Entity\Order & $order);

    /**
     * @param Entity\Order $order
     */
    public function create(Entity\Order & $order);

    public function flush();

    public function setReferenceNumberGenerator(Lib\ReferenceNumber\GeneratorInterface $referenceNumberGenerator);
}
