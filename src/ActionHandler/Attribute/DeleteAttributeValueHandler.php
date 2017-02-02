<?php
namespace inklabs\kommerce\ActionHandler\Attribute;

use inklabs\kommerce\Action\Attribute\DeleteAttributeValueCommand;
use inklabs\kommerce\EntityRepository\AttributeRepositoryInterface;
use inklabs\kommerce\EntityRepository\AttributeValueRepositoryInterface;
use inklabs\kommerce\Lib\Authorization\AuthorizationContextInterface;
use inklabs\kommerce\Lib\Command\CommandHandlerInterface;

final class DeleteAttributeValueHandler implements CommandHandlerInterface
{
    /** @var DeleteAttributeValueCommand */
    private $command;

    /** @var AttributeRepositoryInterface */
    protected $attributeValueRepository;

    public function __construct(
        DeleteAttributeValueCommand $command,
        AttributeValueRepositoryInterface $attributeValueRepository
    ) {
        $this->command = $command;
        $this->attributeValueRepository = $attributeValueRepository;
    }

    public function verifyAuthorization(AuthorizationContextInterface $authorizationContext)
    {
        $authorizationContext->verifyIsAdmin();
    }

    public function handle()
    {
        $attributeValue = $this->attributeValueRepository->findOneById(
            $this->command->getAttributeValueId()
        );
        $this->attributeValueRepository->delete($attributeValue);
    }
}
