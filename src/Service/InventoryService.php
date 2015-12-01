<?php
namespace inklabs\kommerce\Service;

use inklabs\kommerce\Entity\EntityValidatorException;
use inklabs\kommerce\Entity\InventoryLocation;
use inklabs\kommerce\Entity\InventoryTransaction;
use inklabs\kommerce\Entity\Product;
use inklabs\kommerce\EntityRepository\EntityNotFoundException;
use inklabs\kommerce\EntityRepository\InventoryLocationRepositoryInterface;
use inklabs\kommerce\EntityRepository\InventoryTransactionRepositoryInterface;

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
     * @param Product $product
     * @param int $quantity
     * @throws InsufficientInventoryException
     * @throws EntityValidatorException
     */
    public function reserveProduct(Product $product, $quantity)
    {
        if (! $product->isInventoryRequired()) {
            return;
        }

        try {
            $inventoryLocationId = $this->inventoryTransactionRepository->findInventoryIdForProductAndQuantity(
                $product,
                $quantity
            );

            $inventoryLocation = $this->inventoryLocationRepository->findOneById($inventoryLocationId);
        } catch (EntityNotFoundException $e) {
            throw new InsufficientInventoryException;
        }

        $this->transferProduct(
            $product,
            $quantity,
            'Hold ' . ngettext('item', 'items', $quantity) . ' for order',
            $inventoryLocation,
            null,
            InventoryTransaction::TYPE_HOLD
        );
    }

    /**
     * @param Product $product
     * @param int $quantity
     * @param int $sourceLocationId
     * @param int $destinationLocationId
     * @throws InsufficientInventoryException
     * @throws EntityValidatorException
     */
    public function moveProduct(Product $product, $quantity, $sourceLocationId, $destinationLocationId)
    {
        try {
            $sourceLocation = $this->inventoryLocationRepository->findOneById($sourceLocationId);
            $destinationLocation = $this->inventoryLocationRepository->findOneById($destinationLocationId);
        } catch (EntityNotFoundException $e) {
            throw new InsufficientInventoryException;
        }

        $this->transferProduct(
            $product,
            $quantity,
            'Move ' . ngettext('item', 'items', $quantity),
            $sourceLocation,
            $destinationLocation,
            InventoryTransaction::TYPE_MOVE
        );
    }

    /**
     * @param Product $product
     * @param int $quantity
     * @param int $inventoryLocationId
     * @throws EntityNotFoundException
     * @throws EntityValidatorException
     */
    public function addProduct(Product $product, $quantity, $inventoryLocationId)
    {
        $this->adjustInventory(
            $product,
            abs($quantity),
            $inventoryLocationId,
            InventoryTransaction::TYPE_NEW_PRODUCTS
        );
    }

    /**
     * @param Product $product
     * @param int $quantity
     * @param int $inventoryLocationId
     * @throws EntityNotFoundException
     * @throws EntityValidatorException
     */
    public function shipProduct(Product $product, $quantity, $inventoryLocationId)
    {
        $this->adjustInventory(
            $product,
            abs($quantity) * -1,
            $inventoryLocationId,
            InventoryTransaction::TYPE_SHIPPED
        );
    }

    /**
     * @param Product $product
     * @param int $quantity
     * @param int $inventoryLocationId
     * @throws EntityNotFoundException
     * @throws EntityValidatorException
     */
    public function returnProduct(Product $product, $quantity, $inventoryLocationId)
    {
        $this->adjustInventory(
            $product,
            abs($quantity),
            $inventoryLocationId,
            InventoryTransaction::TYPE_RETURNED
        );
    }

    /**
     * @param Product $product
     * @param int $quantity
     * @param int $inventoryLocationId
     * @throws EntityNotFoundException
     * @throws EntityValidatorException
     */
    public function reduceProductForPromotion(Product $product, $quantity, $inventoryLocationId)
    {
        $this->adjustInventory(
            $product,
            abs($quantity) * -1,
            $inventoryLocationId,
            InventoryTransaction::TYPE_PROMOTION
        );
    }

    /**
     * @param Product $product
     * @param int $quantity
     * @param int $inventoryLocationId
     * @throws EntityNotFoundException
     * @throws EntityValidatorException
     */
    public function reduceProductForDamage(Product $product, $quantity, $inventoryLocationId)
    {
        $this->adjustInventory(
            $product,
            abs($quantity) * -1,
            $inventoryLocationId,
            InventoryTransaction::TYPE_DAMAGED
        );
    }

    /**
     * @param Product $product
     * @param int $quantity
     * @param int $inventoryLocationId
     * @throws EntityNotFoundException
     * @throws EntityValidatorException
     */
    public function reduceProductForShrinkage(Product $product, $quantity, $inventoryLocationId)
    {
        $this->adjustInventory(
            $product,
            abs($quantity) * -1,
            $inventoryLocationId,
            InventoryTransaction::TYPE_SHRINKAGE
        );
    }

    /**
     * @param Product $product
     * @param int $quantity (can be negative)
     * @param int $inventoryLocationId
     * @param int $transactionType
     * @throws EntityNotFoundException
     * @throws EntityValidatorException
     */
    private function adjustInventory(Product $product, $quantity, $inventoryLocationId, $transactionType)
    {
        $inventoryLocation = $this->inventoryLocationRepository->findOneById($inventoryLocationId);

        if ($quantity > 0) {
            $sourceLocation = null;
            $destinationLocation = $inventoryLocation;
        } else {
            $sourceLocation = $inventoryLocation;
            $destinationLocation = null;
        }

        $this->transferProduct(
            $product,
            abs($quantity),
            'Adjusting inventory: ' . InventoryTransaction::getTypeTextFromType($transactionType),
            $sourceLocation,
            $destinationLocation,
            $transactionType
        );
    }

    /**
     * @param Product $product
     * @param int $quantity
     * @param string $memo
     * @param InventoryLocation $sourceLocation
     * @param InventoryLocation $destinationLocation
     * @param int $transactionType
     * @throws EntityValidatorException
     */
    private function transferProduct(
        Product $product,
        $quantity,
        $memo,
        InventoryLocation $sourceLocation = null,
        InventoryLocation $destinationLocation = null,
        $transactionType = InventoryTransaction::TYPE_MOVE
    ) {
        $debitTransaction = new InventoryTransaction($sourceLocation, $transactionType);
        $debitTransaction->setProduct($product);
        $debitTransaction->setDebitQuantity($quantity);
        $debitTransaction->setMemo($memo);

        $creditTransaction = new InventoryTransaction($destinationLocation, $transactionType);
        $creditTransaction->setProduct($product);
        $creditTransaction->setCreditQuantity($quantity);
        $creditTransaction->setMemo($memo);

        $this->throwValidationErrors($debitTransaction);
        $this->throwValidationErrors($creditTransaction);

        $this->inventoryTransactionRepository->persist($debitTransaction);
        $this->inventoryTransactionRepository->persist($creditTransaction);
    }
}
