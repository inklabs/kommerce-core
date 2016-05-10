<?php
namespace inklabs\kommerce\tests\Helper\EntityRepository;

use inklabs\kommerce\Entity\Attribute;
use inklabs\kommerce\Entity\AttributeValue;
use inklabs\kommerce\Entity\Pagination;
use inklabs\kommerce\EntityRepository\AttributeValueRepositoryInterface;

/**
 * @method AttributeValue findOneById($id)
 */
class FakeAttributeValueRepository extends AbstractFakeRepository implements AttributeValueRepositoryInterface
{
    protected $entityName = 'AttributeValue';

    public function __construct()
    {
        $this->setReturnValue(new AttributeValue(new Attribute));
    }

    public function getAttributeValuesByIds(array $attributeValueIds, Pagination & $pagination = null)
    {
        return $this->getReturnValueAsArray();
    }
}
