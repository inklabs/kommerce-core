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

    public function getLatestOrders(string $queryString = null, Pagination & $pagination = null): array
    {
        return $this->getQueryBuilder()
            ->select('o')
            ->from(Order::class, 'o')
            ->innerJoin('o.user', 'User')
            ->where('User.firstName LIKE :query')
            ->orWhere('User.lastName LIKE :query')
            ->orWhere('User.email LIKE :query')
            ->setParameter('query', '%' . $queryString . '%')
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
