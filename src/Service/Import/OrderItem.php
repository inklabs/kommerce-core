<?php
namespace inklabs\kommerce\Service\Import;

use Doctrine\ORM\EntityManager;
use inklabs\kommerce\Entity as Entity;
use inklabs\kommerce\EntityRepository as EntityRepository;
use inklabs\kommerce\Lib as Lib;

class OrderItem extends Lib\ServiceManager
{
    /** @var EntityRepository\OrderItem */
    private $orderItemRepository;

    public function __construct(EntityManager $entityManager)
    {
        $this->setEntityManager($entityManager);
        $this->orderItemRepository = $entityManager->getRepository('kommerce:OrderItem');
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
            $sku = $row[1];
            $note = $row[2];
            $quantity = $row[3];
            $unitPrice = $this->convertDollarToCents($row[4]);
            $quantityPrice = $this->convertDollarToCents($row[5]);

            // TODO: Get product via $sku
            $product = new Entity\Product;

            // TODO: Get Order via $orderRef
            $order = new Entity\Order;

            $price = new Entity\Price;
            $price->origUnitPrice = $unitPrice;
            $price->unitPrice = $unitPrice;
            $price->origQuantityPrice = $quantityPrice;
            $price->quantityPrice = $quantityPrice;

            // TODO: Add orderItem description
            $orderItem = new Entity\OrderItem;
            $orderItem->setProduct($product);
            $orderItem->setQuantity($quantity);
            $orderItem->setPrice($price);
            $orderItem->setOrder($order);

            $this->entityManager->persist($orderItem);
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
