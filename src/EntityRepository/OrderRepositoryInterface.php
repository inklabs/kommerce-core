<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity\Order;
use inklabs\kommerce\Entity\OrderItem;
use inklabs\kommerce\Entity\Pagination;
use inklabs\kommerce\Lib\ReferenceNumber;

/**
 * @method Order findOneById($id)
 */
interface OrderRepositoryInterface extends AbstractRepositoryInterface, ReferenceNumber\RepositoryInterface
{
    /**
     * @param int $orderExternalId
     * @return Order
     */
    public function findOneByExternalId($orderExternalId);

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
