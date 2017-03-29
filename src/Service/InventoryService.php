<?php
namespace inklabs\kommerce\Service;

use inklabs\kommerce\Entity\Order;
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

    /**
     * @param Order $order
     * @param Product $product
     * @param int $quantity
     * @throws InsufficientInventoryException
     * @throws EntityValidatorException
     */
    public function reserveProductForOrder(Order $order, Product $product, $quantity)
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

    /**
     * @param Product $product
     * @param int $quantity
     * @param UuidInterface $sourceLocationId
     * @param UuidInterface $destinationLocationId
     * @throws EntityNotFoundException
     * @throws EntityValidatorException
     */
    public function moveProduct(
        Product $product,
        $quantity,
        UuidInterface $sourceLocationId,
        UuidInterface $destinationLocationId
    ) {
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

    /**
     * @param Product $product
     * @param int $quantity
     * @param UuidInterface $inventoryLocationId
     * @throws EntityNotFoundException
     * @throws EntityValidatorException
     */
    public function addProduct(Product $product, $quantity, UuidInterface $inventoryLocationId)
    {
        $this->adjustInventory(
            $product,
            abs($quantity),
            $inventoryLocationId,
            InventoryTransactionType::newProducts()
        );
    }

    /**
     * @param Product $product
     * @param int $quantity
     * @param UuidInterface $inventoryLocationId
     * @throws EntityNotFoundException
     * @throws EntityValidatorException
     */
    public function shipProduct(Product $product, $quantity, UuidInterface $inventoryLocationId)
    {
        $this->adjustInventory(
            $product,
            abs($quantity) * -1,
            $inventoryLocationId,
            InventoryTransactionType::shipped()
        );
    }

    /**
     * @param Product $product
     * @param int $quantity
     * @param UuidInterface $inventoryLocationId
     * @throws EntityNotFoundException
     * @throws EntityValidatorException
     */
    public function returnProduct(Product $product, $quantity, UuidInterface $inventoryLocationId)
    {
        $this->adjustInventory(
            $product,
            abs($quantity),
            $inventoryLocationId,
            InventoryTransactionType::returned()
        );
    }

    /**
     * @param Product $product
     * @param int $quantity
     * @param UuidInterface $inventoryLocationId
     * @throws EntityNotFoundException
     * @throws EntityValidatorException
     */
    public function reduceProductForPromotion(Product $product, $quantity, UuidInterface $inventoryLocationId)
    {
        $this->adjustInventory(
            $product,
            abs($quantity) * -1,
            $inventoryLocationId,
            InventoryTransactionType::promotion()
        );
    }

    /**
     * @param Product $product
     * @param int $quantity
     * @param UuidInterface $inventoryLocationId
     * @throws EntityNotFoundException
     * @throws EntityValidatorException
     */
    public function reduceProductForDamage(Product $product, $quantity, UuidInterface $inventoryLocationId)
    {
        $this->adjustInventory(
            $product,
            abs($quantity) * -1,
            $inventoryLocationId,
            InventoryTransactionType::damaged()
        );
    }

    /**
     * @param Product $product
     * @param int $quantity
     * @param UuidInterface $inventoryLocationId
     * @throws EntityNotFoundException
     * @throws EntityValidatorException
     */
    public function reduceProductForShrinkage(Product $product, $quantity, UuidInterface $inventoryLocationId)
    {
        $this->adjustInventory(
            $product,
            abs($quantity) * -1,
            $inventoryLocationId,
            InventoryTransactionType::shrinkage()
        );
    }

    /**
     * @param Product $product
     * @param int $quantity (can be negative)
     * @param UuidInterface $inventoryLocationId
     * @param InventoryTransactionType $transactionType
     * @throws EntityNotFoundException
     * @throws EntityValidatorException
     */
    public function adjustInventory(
        Product $product,
        $quantity,
        UuidInterface $inventoryLocationId,
        InventoryTransactionType $transactionType
    ) {
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

    /**
     * @param Product $product
     * @param int $quantity
     * @param string $memo
     * @param InventoryLocation $sourceLocation
     * @param InventoryLocation $destinationLocation
     * @param InventoryTransactionType $transactionType
     * @throws EntityValidatorException
     */
    private function transferProduct(
        Product $product,
        $quantity,
        $memo,
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
