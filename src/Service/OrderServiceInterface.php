<?php
namespace inklabs\kommerce\Service;

use inklabs\kommerce\Entity\Order;
use inklabs\kommerce\Entity\Pagination;
use inklabs\kommerce\EntityRepository\EntityNotFoundException;

interface OrderServiceInterface
{
    /**
     * @param int $id
     * @return Order
     * @throws EntityNotFoundException
     */
    public function findOneById($id);

    public function getLatestOrders(Pagination &$pagination = null);

    /**
     * @param int $userId
     * @return Order[]
     */
    public function getOrdersByUserId($userId);
}
