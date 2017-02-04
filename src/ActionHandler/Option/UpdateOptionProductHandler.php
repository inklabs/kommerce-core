<?php
namespace inklabs\kommerce\ActionHandler\Option;

use inklabs\kommerce\Action\Option\UpdateOptionProductCommand;
use inklabs\kommerce\EntityDTO\Builder\OptionProductDTOBuilder;
use inklabs\kommerce\EntityRepository\OptionProductRepositoryInterface;
use inklabs\kommerce\EntityRepository\OptionRepositoryInterface;
use inklabs\kommerce\Lib\Authorization\AuthorizationContextInterface;
use inklabs\kommerce\Lib\Command\CommandHandlerInterface;

final class UpdateOptionProductHandler implements CommandHandlerInterface
{
    /** @var UpdateOptionProductCommand */
    private $command;

    /** @var OptionRepositoryInterface */
    protected $optionRepository;

    /** @var OptionProductRepositoryInterface */
    private $optionProductRepository;

    public function __construct(
        UpdateOptionProductCommand $command,
        OptionRepositoryInterface $optionRepository,
        OptionProductRepositoryInterface $optionProductRepository
    ) {
        $this->command = $command;
        $this->optionRepository = $optionRepository;
        $this->optionProductRepository = $optionProductRepository;
    }

    public function verifyAuthorization(AuthorizationContextInterface $authorizationContext)
    {
        $authorizationContext->verifyIsAdmin();
    }

    public function handle()
    {
        $optionProductDTO = $this->command->getOptionProductDTO();
        $optionProduct = $this->optionRepository->getOptionProductById($optionProductDTO->id);
        OptionProductDTOBuilder::setFromDTO($optionProduct, $optionProductDTO);

        $this->optionProductRepository->update($optionProduct);
    }
}
