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
            if ($key < 2 && $row[0] === 'order_id') {
                continue;
            }

            $orderId = $row[0];
            $sku = $row[1];
            $note = $row[2];
            $quantity = $row[3];
            $unitPrice = round($row[4] * 100);
            $quantityPrice = round($row[5] * 100);

            // TODO: Get product via $sku
            $product = new Entity\Product;

            // TODO: Refactor Order to not require order items or cartTotal
            // TODO: Get Order via $orderId
            $order = new Entity\Order([], new Entity\CartTotal);

            $price = new Entity\Price;
            $price->origUnitPrice = $unitPrice;
            $price->unitPrice = $unitPrice;
            $price->origQuantityPrice = $quantityPrice;
            $price->quantityPrice = $quantityPrice;

            $orderItem = new Entity\OrderItem($product, $quantity, $price);
            $orderItem->setOrder($order);

            // TODO: Refactor OrderItem to not require a product
            // TODO: Add orderItem description

            $this->entityManager->persist($orderItem);
            $importedCount++;
        }

        $this->entityManager->flush();

        return $importedCount;
    }
}
