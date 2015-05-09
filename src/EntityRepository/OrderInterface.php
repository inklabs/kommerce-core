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
     * @param array $criteria
     * @param array $orderBy
     * @return Entity\Order
     */
    public function findOneBy(array $criteria, array $orderBy = null);

    /**
     * @param Entity\Pagination $pagination
     * @return Entity\Order[]
     */
    public function getLatestOrders(Entity\Pagination & $pagination = null);

    /**
     * @param $userId
     * @return Entity\Order[]
     */
    public function getOrdersByUserId($userId);

    /**
     * @param Entity\Order $order
     */
    public function save(Entity\Order & $order);

    /**
     * @param Entity\Order $order
     */
    public function create(Entity\Order & $order);

    /**
     * @param Entity\Order $order
     */
    public function persist(Entity\Order & $order);

    public function flush();

    public function setReferenceNumberGenerator(Lib\ReferenceNumber\GeneratorInterface $referenceNumberGenerator);
}
