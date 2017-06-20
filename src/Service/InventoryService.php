<?php
namespace inklabs\kommerce\Service;

use inklabs\kommerce\Entity\Order;
use inklabs\kommerce\Entity\OrderItem;
use inklabs\kommerce\Exception\EntityValidatorException;
use inklabs\kommerce\Entity\InventoryLocation;
use inklabs\kommerce\Entity\InventoryTransaction;
use inklabs\kommerce\Entity\InventoryTransactionType;
use inklabs\kommerce\Entity\Product;
use inklabs\kommerce\Exception\EntityNotFoundException;
use inklabs\kommerce\EntityRepository\InventoryLocationRepositoryInterface;
use inklabs\kommerce\EntityRepository\InventoryTransactionRepositoryInterface;
use inklabs\kommerce\Exception\InsufficientInventoryException;
use inklabs\kommerce\Lib\UuidInterface;

class InventoryService implements InventoryServiceInterface
{
    use EntityValidationTrait;

    /** @var InventoryLocationRepositoryInterface */
    private $inventoryLocationRepository;

    /** @var InventoryTransactionRepositoryInterface */
    private $inventoryTransactionRepository;

    public function __construct(
        InventoryLocationRepositoryInterface $inventoryLocationRepository,
        InventoryTransactionRepositoryInterface $inventoryTransactionRepository
    ) {
        $this->inventoryLocationRepository = $inventoryLocationRepository;
        $this->inventoryTransactionRepository = $inventoryTransactionRepository;
    }

    public function reserveProductForOrder(Order $order, Product $product, int $quantity): void
    {
        if (! $product->isInventoryRequired()) {
            // TODO: Investigate throwing exception in this case
            return;
        }

        try {
            $inventoryLocationId = $this->inventoryTransactionRepository
                ->findInventoryIdWithAvailableQuantityForProduct(
                    $product,
                    $quantity
                );

            $inventoryLocation = $this->inventoryLocationRepository->findOneById($inventoryLocationId);
        } catch (EntityNotFoundException $e) {
            throw new InsufficientInventoryException();
        }

        $inventoryTransaction = InventoryTransaction::debit(
            $product,
            $quantity,
            'Hold ' . ngettext('item', 'items', $quantity) . ' for order #' . $order->getReferenceNumber(),
            $inventoryLocation,
            InventoryTransactionType::hold()
        );

        $this->inventoryTransactionRepository->persist($inventoryTransaction);
        $this->inventoryTransactionRepository->flush();
    }

    public function shipProductForOrderItem(OrderItem $orderItem, Product $product, int $quantity): void
    {
        if (! $product->isInventoryRequired()) {
            // TODO: Investigate throwing exception in this case
            return;
        }

        try {
            $inventoryLocationId = $this->inventoryTransactionRepository
                ->findInventoryIdWithAvailableQuantityForProduct(
                    $product,
                    $quantity
                );

            $inventoryLocation = $this->inventoryLocationRepository->findOneById($inventoryLocationId);
        } catch (EntityNotFoundException $e) {
            throw new InsufficientInventoryException();
        }

        $inventoryTransaction = InventoryTransaction::debit(
            $product,
            $quantity,
            'Shipped ' . ngettext('item', 'items', $quantity) . ' for orderItem #' . $orderItem->getId()->getHex(),
            $inventoryLocation,
            InventoryTransactionType::shipped()
        );

        $this->inventoryTransactionRepository->persist($inventoryTransaction);
        $this->inventoryTransactionRepository->flush();
    }

    public function moveProduct(
        Product $product,
        int $quantity,
        UuidInterface $sourceLocationId,
        UuidInterface $destinationLocationId
    ): void {
        $sourceLocation = $this->inventoryLocationRepository->findOneById($sourceLocationId);
        $destinationLocation = $this->inventoryLocationRepository->findOneById($destinationLocationId);

        $this->transferProduct(
            $product,
            $quantity,
            'Move ' . ngettext('item', 'items', $quantity),
            $sourceLocation,
            $destinationLocation,
            InventoryTransactionType::move()
        );
    }

    public function addProduct(Product $product, int $quantity, UuidInterface $inventoryLocationId): void
    {
        $this->adjustInventory(
            $product,
            abs($quantity),
            $inventoryLocationId,
            InventoryTransactionType::newProducts()
        );
    }

    public function shipProduct(Product $product, int $quantity, UuidInterface $inventoryLocationId): void
    {
        $this->adjustInventory(
            $product,
            abs($quantity) * -1,
            $inventoryLocationId,
            InventoryTransactionType::shipped()
        );
    }

    public function returnProduct(Product $product, int $quantity, UuidInterface $inventoryLocationId): void
    {
        $this->adjustInventory(
            $product,
            abs($quantity),
            $inventoryLocationId,
            InventoryTransactionType::returned()
        );
    }

    public function reduceProductForPromotion(Product $product, int $quantity, UuidInterface $inventoryLocationId): void
    {
        $this->adjustInventory(
            $product,
            abs($quantity) * -1,
            $inventoryLocationId,
            InventoryTransactionType::promotion()
        );
    }

    public function reduceProductForDamage(Product $product, int $quantity, UuidInterface $inventoryLocationId): void
    {
        $this->adjustInventory(
            $product,
            abs($quantity) * -1,
            $inventoryLocationId,
            InventoryTransactionType::damaged()
        );
    }

    public function reduceProductForShrinkage(Product $product, int $quantity, UuidInterface $inventoryLocationId): void
    {
        $this->adjustInventory(
            $product,
            abs($quantity) * -1,
            $inventoryLocationId,
            InventoryTransactionType::shrinkage()
        );
    }

    public function adjustInventory(
        Product $product,
        int $quantity,
        UuidInterface $inventoryLocationId,
        InventoryTransactionType $transactionType
    ): void {
        $inventoryLocation = $this->inventoryLocationRepository->findOneById($inventoryLocationId);

        $memo = 'Adjusting inventory: ' . $transactionType->getName();

        if ($quantity > 0) {
            $inventoryTransaction = InventoryTransaction::credit(
                $product,
                $quantity,
                $memo,
                $inventoryLocation,
                $transactionType
            );
        } else {
            $inventoryTransaction = InventoryTransaction::debit(
                $product,
                abs($quantity),
                $memo,
                $inventoryLocation,
                $transactionType
            );
        }
        $this->inventoryTransactionRepository->persist($inventoryTransaction);
        $this->inventoryTransactionRepository->flush();
    }

    private function transferProduct(
        Product $product,
        int $quantity,
        string $memo,
        InventoryLocation $sourceLocation,
        InventoryLocation $destinationLocation,
        InventoryTransactionType $transactionType
    ) {
        $debitTransaction = InventoryTransaction::debit(
            $product,
            $quantity,
            $memo,
            $sourceLocation,
            $transactionType
        );

        $creditTransaction = InventoryTransaction::credit(
            $product,
            $quantity,
            $memo,
            $destinationLocation,
            $transactionType
        );

        $this->inventoryTransactionRepository->persist($debitTransaction);
        $this->inventoryTransactionRepository->persist($creditTransaction);
        $this->inventoryTransactionRepository->flush();
    }
}
