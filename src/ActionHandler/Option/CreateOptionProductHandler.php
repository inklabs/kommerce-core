<?php
namespace inklabs\kommerce\ActionHandler\Option;

use inklabs\kommerce\Action\Option\CreateOptionProductCommand;
use inklabs\kommerce\EntityDTO\Builder\OptionProductDTOBuilder;
use inklabs\kommerce\EntityRepository\OptionProductRepositoryInterface;
use inklabs\kommerce\EntityRepository\OptionRepositoryInterface;
use inklabs\kommerce\EntityRepository\ProductRepositoryInterface;
use inklabs\kommerce\Lib\Authorization\AuthorizationContextInterface;
use inklabs\kommerce\Lib\Command\CommandHandlerInterface;

final class CreateOptionProductHandler implements CommandHandlerInterface
{
    /** @var CreateOptionProductCommand */
    private $command;

    /** @var OptionRepositoryInterface */
    protected $optionRepository;

    /** @var ProductRepositoryInterface */
    private $productRepository;

    /** @var OptionProductRepositoryInterface */
    private $optionProductRepository;

    public function __construct(
        CreateOptionProductCommand $command,
        OptionRepositoryInterface $optionRepository,
        ProductRepositoryInterface $productRepository,
        OptionProductRepositoryInterface $optionProductRepository
    ) {
        $this->command = $command;
        $this->optionRepository = $optionRepository;
        $this->productRepository = $productRepository;
        $this->optionProductRepository = $optionProductRepository;
    }

    public function verifyAuthorization(AuthorizationContextInterface $authorizationContext): void
    {
        $authorizationContext->verifyIsAdmin();
    }

    public function handle()
    {
        $option = $this->optionRepository->findOneById(
            $this->command->getOptionId()
        );

        $product = $this->productRepository->findOneById(
            $this->command->getProductId()
        );

        $optionProduct = OptionProductDTOBuilder::createFromDTO(
            $option,
            $product,
            $this->command->getOptionProductDTO(),
            $this->command->getOptionProductId()
        );

        $this->optionProductRepository->create($optionProduct);
    }
}
