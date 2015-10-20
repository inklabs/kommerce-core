<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity\EntityInterface;
use inklabs\kommerce\Entity\Order;
use inklabs\kommerce\Entity\Pagination;
use inklabs\kommerce\Lib\ReferenceNumber;
use Symfony\Component\Yaml\Exception\RuntimeException;

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

    /** @var ReferenceNumber\GeneratorInterface */
    protected $referenceNumberGenerator;

    public function setReferenceNumberGenerator(ReferenceNumber\GeneratorInterface $referenceNumberGenerator)
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
            ->from('kommerce:Order', 'o')
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
