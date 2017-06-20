<?php
namespace inklabs\kommerce\Service\Import;

use inklabs\kommerce\Entity\OrderItem;
use inklabs\kommerce\Entity\Price;
use inklabs\kommerce\EntityRepository\OrderRepositoryInterface;
use inklabs\kommerce\EntityRepository\OrderItemRepositoryInterface;
use inklabs\kommerce\EntityRepository\ProductRepositoryInterface;
use inklabs\kommerce\Exception\KommerceException;
use inklabs\kommerce\Service\EntityValidationTrait;
use Iterator;

class ImportOrderItemService implements ImportOrderItemServiceInterface
{
    use EntityValidationTrait;

    /** @var OrderItemRepositoryInterface */
    private $orderItemRepository;

    /** @var ProductRepositoryInterface */
    private $productRepository;

    /** @var OrderRepositoryInterface */
    private $orderRepository;

    public function __construct(
        OrderRepositoryInterface $orderRepository,
        OrderItemRepositoryInterface $orderItemRepository,
        ProductRepositoryInterface $productRepository
    ) {
        $this->orderRepository = $orderRepository;
        $this->orderItemRepository = $orderItemRepository;
        $this->productRepository = $productRepository;
    }

    public function import(Iterator $iterator): ImportResult
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

            $price = new Price;
            $price->origUnitPrice = $unitPrice;
            $price->unitPrice = $unitPrice;
            $price->origQuantityPrice = $quantityPrice;
            $price->quantityPrice = $quantityPrice;

            try {
                $order = $this->orderRepository->findOneByExternalId($orderExternalId);

                $orderItem = new OrderItem($order);
                $orderItem->setQuantity($quantity);
                $orderItem->setPrice($price);

                if ($sku === 'NULL') {
                    $orderItem->setName($note);
                } else {
                    $product = $this->productRepository->findOneBySku($sku);
                    if ($product !== null) {
                        $orderItem->setProduct($product);
                    }
                }

                $this->orderItemRepository->persist($orderItem);
                $importResult->incrementSuccess();
            } catch (KommerceException $e) {
                $importResult->addFailedRow($row);
                $importResult->addErrorMessage($e->getMessage());
            }
        }

        $this->orderItemRepository->flush();

        return $importResult;
    }

    private function convertDollarToCents(float $dollarValue): int
    {
        return (int) round($dollarValue * 100);
    }
}
