<?php
namespace inklabs\kommerce\Service\Import;

use inklabs\kommerce\Entity;
use inklabs\kommerce\EntityRepository;
use Symfony\Component\Validator\Exception\ValidatorException;
use Symfony\Component\Validator\Validation;

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
        $validator = Validation::createValidatorBuilder()
            ->addMethodMapping('loadValidatorMetadata')
            ->getValidator();

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
                if ($product !== null) {
                    $orderItem->setProduct($product);
                }
            }

            try {
                $errors = $validator->validate($orderItem);
                if ($errors->count() > 0) {
                    throw new ValidatorException('Invalid Order Item' . $errors);
                }

                $this->orderItemRepository->persist($orderItem);
                $importResult->incrementSuccess();
            } catch (\Exception $e) {
                $importResult->addFailedRow($row);
                $importResult->addErrorMessage($e->getMessage());
            }
        }

        $this->orderItemRepository->flush();

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
