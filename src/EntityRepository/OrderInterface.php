<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity;
use inklabs\kommerce\Lib;
use inklabs\kommerce\Lib\ReferenceNumber;

interface OrderInterface extends ReferenceNumber\RepositoryInterface
{
    public function save(Entity\Order & $order);
    public function create(Entity\Order & $order);
    public function remove(Entity\Order & $order);

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

    public function setReferenceNumberGenerator(Lib\ReferenceNumber\GeneratorInterface $referenceNumberGenerator);
}
