<?php
namespace inklabs\kommerce\ActionHandler\Attribute;

use inklabs\kommerce\Action\Attribute\DeleteAttributeCommand;
use inklabs\kommerce\EntityRepository\AttributeRepositoryInterface;
use inklabs\kommerce\Lib\Authorization\AuthorizationContextInterface;
use inklabs\kommerce\Lib\Command\CommandHandlerInterface;

final class DeleteAttributeHandler implements CommandHandlerInterface
{
    /** @var DeleteAttributeCommand */
    private $command;

    /** @var AttributeRepositoryInterface */
    protected $attributeRepository;

    public function __construct(
        DeleteAttributeCommand $command,
        AttributeRepositoryInterface $attributeRepository
    ) {
        $this->command = $command;
        $this->attributeRepository = $attributeRepository;
    }

    public function verifyAuthorization(AuthorizationContextInterface $authorizationContext)
    {
        $authorizationContext->verifyIsAdmin();
    }

    public function handle()
    {
        $attribute = $this->attributeRepository->findOneById(
            $this->command->getAttributeId()
        );
        $this->attributeRepository->delete($attribute);
    }
}
