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
            if ($key < 2 && $row[0] === 'order_ref') {
                continue;
            }

            $orderRef = $row[0];
            $date = $row[1];
            $userId = $row[2];
            $subtotal = $this->convertDollarToCents($row[3]);
            $tax = $this->convertDollarToCents($row[4]);
            $total = $this->convertDollarToCents($row[5]);

            // TODO: Get User via ??
            $user = new Entity\User;

            $cartTotal = new Entity\CartTotal;
            $cartTotal->subtotal = $subtotal;
            $cartTotal->tax = $tax;
            $cartTotal->total = $total;

            // TODO: Add order ref
            $order = new Entity\Order;
            $order->setTotal($cartTotal);
            $order->setCreated(new \DateTime($date));
            $order->setUser($user);

            $this->entityManager->persist($order);
            $importedCount++;
        }

        $this->entityManager->flush();

        return $importedCount;
    }

    /**
     * @param float $dollarValue
     * @return int
     */
    private function convertDollarToCents($dollarValue)
    {
        return (int) round($dollarValue * 100);
    }
}
