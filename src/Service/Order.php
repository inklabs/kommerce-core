<?php
namespace inklabs\kommerce\Service;

use Doctrine\ORM\EntityManager;
use inklabs\kommerce\EntityRepository as EntityRepository;
use inklabs\kommerce\Entity as Entity;
use inklabs\kommerce\Lib as Lib;

class Order extends Lib\EntityManager
{
    /* @var EntityRepository\Order */
    private $orderRepository;

    public function __construct(EntityManager $entityManager)
    {
        $this->setEntityManager($entityManager);
        $this->orderRepository = $entityManager->getRepository('kommerce:Order');
    }

    /**
     * @return Entity\View\Order|null
     */
    public function find($id)
    {
        /* @var Entity\Order $entityOrder */
        $entityOrder = $this->orderRepository->find($id);

        if ($entityOrder === null) {
            return null;
        }

        return $entityOrder->getView()
            ->withAllData()
            ->export();
    }
}
