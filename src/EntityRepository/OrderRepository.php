<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity\Order;
use inklabs\kommerce\Entity\Pagination;
use inklabs\kommerce\Lib\UuidInterface;

class OrderRepository extends AbstractRepository implements OrderRepositoryInterface
{
    public function findOneByExternalId(string $orderExternalId): Order
    {
        return $this->returnOrThrowNotFoundException(
            parent::findOneBy(['externalId' => $orderExternalId])
        );
    }

    public function referenceNumberExists(string $referenceNumber): bool
    {
        $result = $this->findOneBy([
            'referenceNumber' => $referenceNumber
        ]);

        return $result !== null;
    }

    public function getLatestOrders(Pagination & $pagination = null)
    {
        return $this->getQueryBuilder()
            ->select('o')
            ->from(Order::class, 'o')
            ->paginate($pagination)
            ->orderBy('o.created', 'DESC')
            ->getQuery()
            ->getResult();
    }

    public function getOrdersByUserId(UuidInterface $userId)
    {
        return $this->findBy(['user' => $userId], ['created' => 'DESC']);
    }
}
