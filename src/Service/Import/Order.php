<?php
namespace inklabs\kommerce\Service\Import;

use Doctrine\ORM\EntityManager;
use inklabs\kommerce\Entity;
use inklabs\kommerce\EntityRepository as EntityRepository;
use inklabs\kommerce\Lib;

class Order extends Lib\ServiceManager
{
    /** @var EntityRepository\Order */
    private $orderRepository;

    /** @var EntityRepository\User */
    private $userRepository;

    public function __construct(EntityManager $entityManager)
    {
        $this->setEntityManager($entityManager);
        $this->orderRepository = $entityManager->getRepository('kommerce:Order');
        $this->userRepository = $entityManager->getRepository('kommerce:User');
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

            $externalId = $row[0];
            $date = $row[1];
            $userExternalId = $row[2];
            $subtotal = $this->convertDollarToCents($row[3]);
            $tax = $this->convertDollarToCents($row[4]);
            $total = $this->convertDollarToCents($row[5]);

            $cartTotal = new Entity\CartTotal;
            $cartTotal->subtotal = $subtotal;
            $cartTotal->tax = $tax;
            $cartTotal->total = $total;

            $order = new Entity\Order;
            $order->setExternalId($externalId);
            $order->setTotal($cartTotal);
            $order->setCreated(new \DateTime($date));

            if ($userExternalId !== null) {
                $user = $this->userRepository->findOneBy(['externalId' => $userExternalId]);
                $order->setUser($user);
            }

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
