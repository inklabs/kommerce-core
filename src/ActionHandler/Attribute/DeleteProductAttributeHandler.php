<?php
namespace inklabs\kommerce\ActionHandler\Attribute;

use inklabs\kommerce\Action\Attribute\DeleteProductAttributeCommand;
use inklabs\kommerce\EntityRepository\ProductAttributeRepositoryInterface;
use inklabs\kommerce\Lib\Authorization\AuthorizationContextInterface;
use inklabs\kommerce\Lib\Command\CommandHandlerInterface;

final class DeleteProductAttributeHandler implements CommandHandlerInterface
{
    /** @var DeleteProductAttributeCommand */
    private $command;

    /** @var ProductAttributeRepositoryInterface */
    protected $productAttributeRepository;

    public function __construct(
        DeleteProductAttributeCommand $command,
        ProductAttributeRepositoryInterface $productAttributeRepository
    ) {
        $this->command = $command;
        $this->productAttributeRepository = $productAttributeRepository;
    }

    public function verifyAuthorization(AuthorizationContextInterface $authorizationContext): void
    {
        $authorizationContext->verifyIsAdmin();
    }

    public function handle()
    {
        $productAttribute = $this->productAttributeRepository->findOneById(
            $this->command->getProductAttributeId()
        );

        $this->productAttributeRepository->delete($productAttribute);
    }
}
