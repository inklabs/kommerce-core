<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity\Order;
use inklabs\kommerce\Entity\Pagination;
use inklabs\kommerce\Lib\ReferenceNumber\ReferenceNumberGeneratorInterface;
use inklabs\kommerce\Lib\ReferenceNumber\ReferenceNumberRepositoryInterface;
use inklabs\kommerce\Lib\UuidInterface;

/**
 * @method Order findOneById(UuidInterface $id)
 */
interface OrderRepositoryInterface extends RepositoryInterface, ReferenceNumberRepositoryInterface
{
    /**
     * @param string $orderExternalId
     * @return Order
     */
    public function findOneByExternalId($orderExternalId);

    /**
     * @param Pagination $pagination
     * @return Order[]
     */
    public function getLatestOrders(Pagination & $pagination = null);

    /**
     * @param UuidInterface $userId
     * @return Order[]
     */
    public function getOrdersByUserId(UuidInterface $userId);
}
