<?php
namespace inklabs\kommerce\Service\Import;

use Doctrine\ORM\EntityManager;
use inklabs\kommerce\Entity as Entity;
use inklabs\kommerce\EntityRepository as EntityRepository;
use inklabs\kommerce\Lib as Lib;

class Order extends Lib\ServiceManager
{
    /** @var EntityRepository\Order */
    private $orderRepository;

    public function __construct(EntityManager $entityManager)
    {
        $this->setEntityManager($entityManager);
        $this->orderRepository = $entityManager->getRepository('kommerce:Order');
    }

    /**
     * @param \Iterator $iterator
     * @return int
     */
    public function import(\Iterator $iterator)
    {
        $importedCount = 0;
        foreach ($iterator as $key => $row) {
            if ($key < 2 && $row[0] === 'id') {
                continue;
            }

            $id = $row[0];
            $orderRef = $row[1];
            $date = $row[2];
            $userId = $row[3];
            $subtotal = round($row[4] * 100);
            $tax = round($row[5] * 100);
            $total = round($row[6] * 100);

            $cartTotal = new Entity\CartTotal;
            $cartTotal->subtotal = $subtotal;
            $cartTotal->tax = $tax;
            $cartTotal->total = $total;

            $order = new Entity\Order([], $cartTotal);
            $order->setCreated(new \DateTime($date));

            $this->entityManager->persist($order);
            $importedCount++;
        }

        $this->entityManager->flush();

        return $importedCount;
    }
}
