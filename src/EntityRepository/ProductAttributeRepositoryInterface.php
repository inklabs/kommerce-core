<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity\Pagination;
use inklabs\kommerce\Entity\ProductAttribute;
use inklabs\kommerce\Lib\UuidInterface;

/**
 * @method ProductAttribute findOneById(UuidInterface $id)
 */
interface ProductAttributeRepositoryInterface extends RepositoryInterface
{
    /**
     * @param UuidInterface $attributeValueId
     * @param Pagination|null $pagination
     * @return ProductAttribute[]
     */
    public function getByAttributeValue(UuidInterface $attributeValueId, Pagination & $pagination = null);
}
