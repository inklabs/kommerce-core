<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity\Order;
use inklabs\kommerce\Entity\Pagination;
use inklabs\kommerce\Lib\ReferenceNumber;

/**
 * @method Order find($id)
 */
interface OrderRepositoryInterface extends AbstractRepositoryInterface, ReferenceNumber\RepositoryInterface
{
    /**
     * @param array $criteria
     * @param array $orderBy
     * @return Order
     */
    public function findOneBy(array $criteria, array $orderBy = null);

    /**
     * @param Pagination $pagination
     * @return Order[]
     */
    public function getLatestOrders(Pagination & $pagination = null);

    /**
     * @param int $userId
     * @return Order[]
     */
    public function getOrdersByUserId($userId);

    public function setReferenceNumberGenerator(ReferenceNumber\GeneratorInterface $referenceNumberGenerator);
}
