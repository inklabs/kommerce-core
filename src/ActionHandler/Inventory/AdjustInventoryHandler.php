<?php
namespace inklabs\kommerce\ActionHandler\Inventory;

use inklabs\kommerce\Action\Inventory\AdjustInventoryCommand;
use inklabs\kommerce\Entity\InventoryTransactionType;
use inklabs\kommerce\EntityRepository\ProductRepositoryInterface;
use inklabs\kommerce\Lib\Authorization\AuthorizationContextInterface;
use inklabs\kommerce\Lib\Command\CommandHandlerInterface;
use inklabs\kommerce\Service\InventoryServiceInterface;

final class AdjustInventoryHandler implements CommandHandlerInterface
{
    /** @var AdjustInventoryCommand */
    private $command;

    /** @var InventoryServiceInterface */
    private $inventoryService;

    /** @var ProductRepositoryInterface */
    private $productRepository;

    public function __construct(
        AdjustInventoryCommand $command,
        InventoryServiceInterface $inventoryService,
        ProductRepositoryInterface $productRepository
    ) {
        $this->command = $command;
        $this->inventoryService = $inventoryService;
        $this->productRepository = $productRepository;
    }

    public function verifyAuthorization(AuthorizationContextInterface $authorizationContext): void
    {
        $authorizationContext->verifyIsAdmin();
    }

    public function handle()
    {
        $product = $this->productRepository->findOneById($this->command->getProductId());

        $this->inventoryService->adjustInventory(
            $product,
            $this->command->getQuantity(),
            $this->command->getInventoryLocationId(),
            InventoryTransactionType::createById($this->command->getTransactionTypeId())
        );
    }
}
