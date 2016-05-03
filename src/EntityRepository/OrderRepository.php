<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity\EntityInterface;
use inklabs\kommerce\Entity\Order;
use inklabs\kommerce\Entity\Pagination;
use inklabs\kommerce\Exception\RuntimeException;
use inklabs\kommerce\Lib\ReferenceNumber\ReferenceNumberGeneratorInterface;

class OrderRepository extends AbstractRepository implements OrderRepositoryInterface
{
    /**
     * @param int $orderExternalId
     * @return Order
     */
    public function findOneByExternalId($orderExternalId)
    {
        return $this->returnOrThrowNotFoundException(
            parent::findOneBy(['externalId' => $orderExternalId])
        );
    }

    public function create(EntityInterface & $entity)
    {
        parent::create($entity);

        $this->setReferenceNumber($entity);
        $this->flush();
    }

    /** @var ReferenceNumberGeneratorInterface */
    protected $referenceNumberGenerator;

    public function setReferenceNumberGenerator(ReferenceNumberGeneratorInterface $referenceNumberGenerator)
    {
        $this->referenceNumberGenerator = $referenceNumberGenerator;
    }

    public function referenceNumberExists($referenceNumber)
    {
        $result = $this->findOneBy([
            'referenceNumber' => $referenceNumber
        ]);

        if ($result === null) {
            return false;
        } else {
            return true;
        }
    }

    public function getLatestOrders(Pagination & $pagination = null)
    {
        return $this->getQueryBuilder()
            ->select('o')
            ->from(Order::class, 'o')
            ->paginate($pagination)
            ->orderBy('o.id', 'DESC')
            ->getQuery()
            ->getResult();
    }

    private function setReferenceNumber(Order & $order)
    {
        if ($this->referenceNumberGenerator !== null) {
            $this->tryToGenerateReferenceNumber($order);
        }
    }

    private function tryToGenerateReferenceNumber(Order & $order)
    {
        try {
            $this->referenceNumberGenerator->generate($order);
            $this->update($order);
        } catch (RuntimeException $e) {
        }
    }

    public function getOrdersByUserId($userId)
    {
        return $this->findBy(['user' => $userId], ['created' => 'DESC']);
    }
}
