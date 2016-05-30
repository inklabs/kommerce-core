<?php
namespace inklabs\kommerce\Service;

use inklabs\kommerce\Entity\EntityValidatorException;
use inklabs\kommerce\Entity\InventoryLocation;
use inklabs\kommerce\Entity\InventoryTransaction;
use inklabs\kommerce\Entity\InventoryTransactionType;
use inklabs\kommerce\Entity\Product;
use inklabs\kommerce\Exception\EntityNotFoundException;
use inklabs\kommerce\EntityRepository\InventoryLocationRepositoryInterface;
use inklabs\kommerce\EntityRepository\InventoryTransactionRepositoryInterface;
use inklabs\kommerce\Exception\InsufficientInventoryException;
use Ramsey\Uuid\UuidInterface;

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
            // TODO: Investigate throwing exception in this case
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
            InventoryTransactionType::hold()
        );
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
            'Adjusting inventory: ' . $transactionType->getName(),
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
     * @param InventoryTransactionType $transactionType
     * @throws EntityValidatorException
     */
    private function transferProduct(
        Product $product,
        $quantity,
        $memo,
        InventoryLocation $sourceLocation = null,
        InventoryLocation $destinationLocation = null,
        InventoryTransactionType $transactionType = null
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
        $this->inventoryTransactionRepository->flush();
    }
}
