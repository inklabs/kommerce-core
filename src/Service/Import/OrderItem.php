<?php
namespace inklabs\kommerce\Service\Import;

use Doctrine\ORM\EntityManager;
use inklabs\kommerce\Entity;
use inklabs\kommerce\EntityRepository;

class OrderItem
{
    /** @var EntityRepository\OrderItem */
    private $orderItemRepository;

    /** @var EntityRepository\Product */
    private $productRepository;

    /** @var EntityRepository\Order */
    private $orderRepository;

    public function __construct(EntityManager $entityManager)
    {
        $this->setEntityManager($entityManager);
        $this->orderItemRepository = $entityManager->getRepository('kommerce:OrderItem');
        $this->productRepository = $entityManager->getRepository('kommerce:Product');
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

            $orderExternalId = $row[0];
            $sku = $row[1];
            $note = $row[2];
            $quantity = $row[3];
            $unitPrice = $this->convertDollarToCents($row[4]);
            $quantityPrice = $this->convertDollarToCents($row[5]);

            $order = $this->orderRepository->findOneBy(['externalId' => $orderExternalId]);

            $price = new Entity\Price;
            $price->origUnitPrice = $unitPrice;
            $price->unitPrice = $unitPrice;
            $price->origQuantityPrice = $quantityPrice;
            $price->quantityPrice = $quantityPrice;

            $orderItem = new Entity\OrderItem;
            $orderItem->setQuantity($quantity);
            $orderItem->setPrice($price);
            $orderItem->setOrder($order);

            if ($sku === 'NULL') {
                $orderItem->setName($note);
            } else {
                $product = $this->productRepository->findOneBy(['sku' => $sku]);
                $orderItem->setProduct($product);
            }

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
