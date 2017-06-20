<?php
namespace inklabs\kommerce\ActionHandler\Attribute;

use inklabs\kommerce\Action\Attribute\UpdateAttributeCommand;
use inklabs\kommerce\EntityRepository\AttributeRepositoryInterface;
use inklabs\kommerce\Lib\Authorization\AuthorizationContextInterface;
use inklabs\kommerce\Lib\Command\CommandHandlerInterface;

final class UpdateAttributeHandler implements CommandHandlerInterface
{
    use UpdateAttributeHandlerTrait;

    /** @var UpdateAttributeCommand */
    private $command;

    /** @var AttributeRepositoryInterface */
    protected $attributeRepository;

    public function __construct(UpdateAttributeCommand $command, AttributeRepositoryInterface $attributeRepository)
    {
        $this->command = $command;
        $this->attributeRepository = $attributeRepository;
    }

    public function verifyAuthorization(AuthorizationContextInterface $authorizationContext): void
    {
        $authorizationContext->verifyIsAdmin();
    }

    public function handle()
    {
        $attribute = $this->attributeRepository->findOneById(
            $this->command->getAttributeId()
        );

        $this->updateAttributeFromCommand($attribute, $this->command);

        $this->attributeRepository->update($attribute);
    }
}
