<?php
namespace inklabs\kommerce\Action\Inventory\Handler;

use inklabs\kommerce\Action\Inventory\AdjustInventoryCommand;
use inklabs\kommerce\Service\InventoryServiceInterface;
use inklabs\kommerce\Service\ProductServiceInterface;

class AdjustInventoryHandler
{
    /** @var InventoryServiceInterface */
    private $inventoryService;

    /** @var ProductServiceInterface */
    private $productService;

    public function __construct(
        InventoryServiceInterface $inventoryService,
        ProductServiceInterface $productService
    ) {
        $this->inventoryService = $inventoryService;
        $this->productService = $productService;
    }

    public function handle(AdjustInventoryCommand $command)
    {
        $product = $this->productService->findOneById($command->getProductId());

        $this->inventoryService->adjustInventory(
            $product,
            $command->getQuantity(),
            $command->getInventoryLocationId(),
            $command->getTransactionType()
        );
    }
}
