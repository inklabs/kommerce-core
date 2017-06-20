<?php
namespace inklabs\kommerce\ActionHandler\Attribute;

use inklabs\kommerce\Action\Attribute\CreateAttributeValueCommand;
use inklabs\kommerce\Entity\AttributeValue;
use inklabs\kommerce\EntityRepository\AttributeRepositoryInterface;
use inklabs\kommerce\EntityRepository\AttributeValueRepositoryInterface;
use inklabs\kommerce\Lib\Authorization\AuthorizationContextInterface;
use inklabs\kommerce\Lib\Command\CommandHandlerInterface;

final class CreateAttributeValueHandler implements CommandHandlerInterface
{
    /** @var CreateAttributeValueCommand */
    private $command;

    /** @var AttributeRepositoryInterface */
    protected $attributeRepository;

    /** @var AttributeValueRepositoryInterface */
    private $attributeValueRepository;

    public function __construct(
        CreateAttributeValueCommand $command,
        AttributeRepositoryInterface $attributeRepository,
        AttributeValueRepositoryInterface $attributeValueRepository
    ) {
        $this->command = $command;
        $this->attributeRepository = $attributeRepository;
        $this->attributeValueRepository = $attributeValueRepository;
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

        $attributeValue = new AttributeValue(
            $attribute,
            $this->command->getName(),
            $this->command->getSortOrder(),
            $this->command->getAttributeValueId()
        );
        $attributeValue->setSku($this->command->getSku());
        $attributeValue->setDescription($this->command->getDescription());

        $this->attributeValueRepository->create($attributeValue);
    }
}
