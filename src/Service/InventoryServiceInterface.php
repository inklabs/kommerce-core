<?php
namespace inklabs\kommerce\Service;

use inklabs\kommerce\Entity\Order;
use inklabs\kommerce\Entity\OrderItem;
use inklabs\kommerce\Exception\EntityValidatorException;
use inklabs\kommerce\Entity\InventoryTransactionType;
use inklabs\kommerce\Entity\Product;
use inklabs\kommerce\Exception\EntityNotFoundException;
use inklabs\kommerce\Exception\InsufficientInventoryException;
use inklabs\kommerce\Lib\UuidInterface;

interface InventoryServiceInterface
{
    public function reserveProductForOrder(Order $order, Product $product, int $quantity): void;

    public function shipProductForOrderItem(OrderItem $orderItem, Product $product, int $quantity): void;

    public function moveProduct(
        Product $product,
        int $quantity,
        UuidInterface $sourceLocationId,
        UuidInterface $destinationLocationId
    ): void;

    public function adjustInventory(
        Product $product,
        int $quantity,
        UuidInterface $inventoryLocationId,
        InventoryTransactionType $transactionType
    ): void;

    public function addProduct(Product $product, int $quantity, UuidInterface $inventoryLocationId): void;
    public function shipProduct(Product $product, int $quantity, UuidInterface $inventoryLocationId): void;
    public function returnProduct(Product $product, int $quantity, UuidInterface $inventoryLocationId): void;

    public function reduceProductForPromotion(
        Product $product,
        int $quantity,
        UuidInterface $inventoryLocationId
    ): void;

    public function reduceProductForDamage(
        Product $product,
        int $quantity,
        UuidInterface $inventoryLocationId
    ): void;

    public function reduceProductForShrinkage(
        Product $product,
        int $quantity,
        UuidInterface $inventoryLocationId
    ): void;
}
