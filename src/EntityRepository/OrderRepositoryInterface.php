<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity\Order;
use inklabs\kommerce\Entity\Pagination;
use inklabs\kommerce\Lib\ReferenceNumber\ReferenceNumberRepositoryInterface;
use inklabs\kommerce\Lib\UuidInterface;

/**
 * @method Order findOneById(UuidInterface $id)
 */
interface OrderRepositoryInterface extends RepositoryInterface, ReferenceNumberRepositoryInterface
{
    public function findOneByExternalId(string $orderExternalId): Order;

    /**
     * @param string $queryString
     * @param Pagination $pagination
     * @return Order[]
     */
    public function getLatestOrders(string $queryString = null, Pagination & $pagination = null): array;

    /**
     * @param UuidInterface $userId
     * @return Order[]
     */
    public function getOrdersByUserId(UuidInterface $userId);
}
