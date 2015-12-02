<?php
namespace inklabs\kommerce\Service;

use inklabs\kommerce\Entity\EntityValidatorException;
use inklabs\kommerce\Entity\Product;
use inklabs\kommerce\EntityRepository\EntityNotFoundException;
use InvalidArgumentException;

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
     * @throws EntityNotFoundException
     * @throws EntityValidatorException
     */
    public function moveProduct(Product $product, $quantity, $sourceLocationId, $destinationLocationId);

    /**
     * @param Product $product
     * @param int $quantity (can be negative)
     * @param int $inventoryLocationId
     * @param int $transactionType
     * @throws EntityNotFoundException
     * @throws EntityValidatorException
     * @throws InvalidArgumentException
     */
    public function adjustInventory(Product $product, $quantity, $inventoryLocationId, $transactionType);

    /**
     * @param Product $product
     * @param int $quantity
     * @param int $inventoryLocationId
     * @throws EntityNotFoundException
     * @throws EntityValidatorException
     */
    public function addProduct(Product $product, $quantity, $inventoryLocationId);

    /**
     * @param Product $product
     * @param int $quantity
     * @param int $inventoryLocationId
     * @throws EntityNotFoundException
     * @throws EntityValidatorException
     */
    public function shipProduct(Product $product, $quantity, $inventoryLocationId);

    /**
     * @param Product $product
     * @param int $quantity
     * @param int $inventoryLocationId
     * @throws EntityNotFoundException
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
     * @throws EntityNotFoundException
     * @throws EntityValidatorException
     */
    public function reduceProductForDamage(Product $product, $quantity, $inventoryLocationId);

    /**
     * @param Product $product
     * @param int $quantity
     * @param int $inventoryLocationId
     * @throws EntityNotFoundException
     * @throws EntityValidatorException
     */
    public function reduceProductForShrinkage(Product $product, $quantity, $inventoryLocationId);
}
