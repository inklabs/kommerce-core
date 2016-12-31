<?php
namespace inklabs\kommerce\ActionHandler\Attribute;

use inklabs\kommerce\Action\Attribute\DeleteAttributeCommand;
use inklabs\kommerce\EntityRepository\AttributeRepositoryInterface;

final class DeleteAttributeHandler
{
    /** @var AttributeRepositoryInterface */
    protected $attributeRepository;

    public function __construct(AttributeRepositoryInterface $attributeRepository)
    {
        $this->attributeRepository = $attributeRepository;
    }

    public function handle(DeleteAttributeCommand $command)
    {
        $attribute = $this->attributeRepository->findOneById($command->getAttributeId());
        $this->attributeRepository->delete($attribute);
    }
}
