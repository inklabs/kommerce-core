<?php
namespace inklabs\kommerce\ActionHandler\Attribute;

use inklabs\kommerce\Action\Attribute\DeleteProductAttributeCommand;
use inklabs\kommerce\EntityRepository\ProductAttributeRepositoryInterface;

final class DeleteProductAttributeHandler
{
    /** @var ProductAttributeRepositoryInterface */
    protected $productAttributeRepository;

    public function __construct(ProductAttributeRepositoryInterface $productAttributeRepository)
    {
        $this->productAttributeRepository = $productAttributeRepository;
    }

    public function handle(DeleteProductAttributeCommand $command)
    {
        $productAttribute = $this->productAttributeRepository->findOneById(
            $command->getProductAttributeId()
        );

        $this->productAttributeRepository->delete($productAttribute);
    }
}
