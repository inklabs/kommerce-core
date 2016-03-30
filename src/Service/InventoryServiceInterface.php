<?php
namespace inklabs\kommerce\Service;

use inklabs\kommerce\Entity\EntityValidatorException;
use inklabs\kommerce\Entity\InventoryTransactionType;
use inklabs\kommerce\Entity\Product;
use inklabs\kommerce\Exception\EntityNotFoundException;
use inklabs\kommerce\Exception\InsufficientInventoryException;

interface InventoryServiceInterface
{
    /**
     * @param Product $product
     * @param int $quantity
     * @throws InsufficientInventoryException
     * @throws EntityValidatorException
     */
    public function reserveProduct(Product $product, $quantity);

    /**
     * @param Product $product
     * @param int $quantity
     * @param int $sourceLocationId
     * @param int $destinationLocationId
     * @throws \inklabs\kommerce\Exception\EntityNotFoundException
     * @throws EntityValidatorException
     */
    public function moveProduct(Product $product, $quantity, $sourceLocationId, $destinationLocationId);

    /**
     * @param Product $product
     * @param int $quantity (can be negative)
     * @param int $inventoryLocationId
     * @param InventoryTransactionType $transactionType
     * @throws \inklabs\kommerce\Exception\EntityNotFoundException
     * @throws EntityValidatorException
     */
    public function adjustInventory(
        Product $product,
        $quantity,
        $inventoryLocationId,
        InventoryTransactionType $transactionType
    );

    /**
     * @param Product $product
     * @param int $quantity
     * @param int $inventoryLocationId
     * @throws \inklabs\kommerce\Exception\EntityNotFoundException
     * @throws EntityValidatorException
     */
    public function addProduct(Product $product, $quantity, $inventoryLocationId);

    /**
     * @param Product $product
     * @param int $quantity
     * @param int $inventoryLocationId
     * @throws \inklabs\kommerce\Exception\EntityNotFoundException
     * @throws EntityValidatorException
     */
    public function shipProduct(Product $product, $quantity, $inventoryLocationId);

    /**
     * @param Product $product
     * @param int $quantity
     * @param int $inventoryLocationId
     * @throws \inklabs\kommerce\Exception\EntityNotFoundException
     * @throws EntityValidatorException
     */
    public function returnProduct(Product $product, $quantity, $inventoryLocationId);

    /**
     * @param Product $product
     * @param int $quantity
     * @param int $inventoryLocationId
     * @throws EntityNotFoundException
     * @throws EntityValidatorException
     */
    public function reduceProductForPromotion(Product $product, $quantity, $inventoryLocationId);

    /**
     * @param Product $product
     * @param int $quantity
     * @param int $inventoryLocationId
     * @throws \inklabs\kommerce\Exception\EntityNotFoundException
     * @throws EntityValidatorException
     */
    public function reduceProductForDamage(Product $product, $quantity, $inventoryLocationId);

    /**
     * @param Product $product
     * @param int $quantity
     * @param int $inventoryLocationId
     * @throws \inklabs\kommerce\Exception\EntityNotFoundException
     * @throws EntityValidatorException
     */
    public function reduceProductForShrinkage(Product $product, $quantity, $inventoryLocationId);
}
