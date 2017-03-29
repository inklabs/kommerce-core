<?php
namespace inklabs\kommerce\Service;

use inklabs\kommerce\Entity\Order;
use inklabs\kommerce\Exception\EntityValidatorException;
use inklabs\kommerce\Entity\InventoryTransactionType;
use inklabs\kommerce\Entity\Product;
use inklabs\kommerce\Exception\EntityNotFoundException;
use inklabs\kommerce\Exception\InsufficientInventoryException;
use inklabs\kommerce\Lib\UuidInterface;

interface InventoryServiceInterface
{
    /**
     * @param Order $order
     * @param Product $product
     * @param int $quantity
     * @throws InsufficientInventoryException
     * @throws EntityValidatorException
     */
    public function reserveProductForOrder(Order $order, Product $product, $quantity);

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
    );

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
    );

    /**
     * @param Product $product
     * @param int $quantity
     * @param UuidInterface $inventoryLocationId
     * @throws EntityNotFoundException
     * @throws EntityValidatorException
     */
    public function addProduct(Product $product, $quantity, UuidInterface $inventoryLocationId);

    /**
     * @param Product $product
     * @param int $quantity
     * @param UuidInterface $inventoryLocationId
     * @throws EntityNotFoundException
     * @throws EntityValidatorException
     */
    public function shipProduct(Product $product, $quantity, UuidInterface $inventoryLocationId);

    /**
     * @param Product $product
     * @param int $quantity
     * @param UuidInterface $inventoryLocationId
     * @throws EntityNotFoundException
     * @throws EntityValidatorException
     */
    public function returnProduct(Product $product, $quantity, UuidInterface $inventoryLocationId);

    /**
     * @param Product $product
     * @param int $quantity
     * @param UuidInterface $inventoryLocationId
     * @throws EntityNotFoundException
     * @throws EntityValidatorException
     */
    public function reduceProductForPromotion(Product $product, $quantity, UuidInterface $inventoryLocationId);

    /**
     * @param Product $product
     * @param int $quantity
     * @param UuidInterface $inventoryLocationId
     * @throws EntityNotFoundException
     * @throws EntityValidatorException
     */
    public function reduceProductForDamage(Product $product, $quantity, UuidInterface $inventoryLocationId);

    /**
     * @param Product $product
     * @param int $quantity
     * @param UuidInterface $inventoryLocationId
     * @throws EntityNotFoundException
     * @throws EntityValidatorException
     */
    public function reduceProductForShrinkage(Product $product, $quantity, UuidInterface $inventoryLocationId);
}
