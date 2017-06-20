<?php
namespace inklabs\kommerce\ActionHandler\Attribute;

use inklabs\kommerce\Action\Attribute\CreateAttributeCommand;
use inklabs\kommerce\Entity\Attribute;
use inklabs\kommerce\EntityRepository\AttributeRepositoryInterface;
use inklabs\kommerce\Lib\Authorization\AuthorizationContextInterface;
use inklabs\kommerce\Lib\Command\CommandHandlerInterface;

final class CreateAttributeHandler implements CommandHandlerInterface
{
    use UpdateAttributeHandlerTrait;

    /** @var CreateAttributeCommand */
    private $command;

    /** @var AttributeRepositoryInterface */
    protected $attributeRepository;

    public function __construct(CreateAttributeCommand $command, AttributeRepositoryInterface $attributeRepository)
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
        $attribute = new Attribute(
            $this->command->getName(),
            $this->command->getChoiceType(),
            $this->command->getSortOrder(),
            $this->command->getAttributeId()
        );

        $this->updateAttributeFromCommand($attribute, $this->command);

        $this->attributeRepository->create($attribute);
    }
}
