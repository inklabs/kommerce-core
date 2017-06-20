<?php
namespace inklabs\kommerce\ActionHandler\Attribute;

use inklabs\kommerce\Action\Attribute\UpdateAttributeValueCommand;
use inklabs\kommerce\EntityRepository\AttributeValueRepositoryInterface;
use inklabs\kommerce\Lib\Authorization\AuthorizationContextInterface;
use inklabs\kommerce\Lib\Command\CommandHandlerInterface;

final class UpdateAttributeValueHandler implements CommandHandlerInterface
{
    /** @var UpdateAttributeValueCommand */
    private $command;

    /** @var AttributeValueRepositoryInterface */
    private $attributeValueRepository;

    public function __construct(
        UpdateAttributeValueCommand $command,
        AttributeValueRepositoryInterface $attributeValueRepository
    ) {
        $this->command = $command;
        $this->attributeValueRepository = $attributeValueRepository;
    }

    public function verifyAuthorization(AuthorizationContextInterface $authorizationContext): void
    {
        $authorizationContext->verifyIsAdmin();
    }

    public function handle()
    {
        $attributeValue = $this->attributeValueRepository->findOneById(
            $this->command->getAttributeValueId()
        );

        $attributeValue->setName($this->command->getName());
        $attributeValue->setSortOrder($this->command->getSortOrder());
        $attributeValue->setSku($this->command->getSku());
        $attributeValue->setDescription($this->command->getDescription());

        $this->attributeValueRepository->update($attributeValue);
    }
}
