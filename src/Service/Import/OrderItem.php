<?php
namespace inklabs\kommerce\Service\Import;

use Doctrine\ORM\EntityManager;
use inklabs\kommerce\Entity;
use inklabs\kommerce\EntityRepository;

class OrderItem
{
    /** @var EntityRepository\OrderItemInterface */
    private $orderItemRepository;

    /** @var EntityRepository\ProductInterface */
    private $productRepository;

    /** @var EntityRepository\OrderInterface */
    private $orderRepository;

    public function __construct(
        EntityRepository\OrderInterface $orderRepository,
        EntityRepository\OrderItemInterface $orderItemRepository,
        EntityRepository\ProductInterface $productRepository
    ) {
        $this->orderRepository = $orderRepository;
        $this->orderItemRepository = $orderItemRepository;
        $this->productRepository = $productRepository;
    }

    /**
     * @param \Iterator $iterator
     * @return ImportResult
     */
    public function import(\Iterator $iterator)
    {
        $importResult = new ImportResult;
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

            try {
                $this->orderItemRepository->create($orderItem);
                $importResult->incrementSuccess();
            } catch (\Exception $e) {
                $importResult->addFailedRow($row);
            }
        }

        return $importResult;
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
