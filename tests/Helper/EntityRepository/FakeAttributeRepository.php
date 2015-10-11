<?php
namespace inklabs\kommerce\tests\Helper\EntityRepository;

use inklabs\kommerce\Entity\Attribute;
use inklabs\kommerce\EntityRepository\AttributeRepositoryInterface;

/**
 * @method Attribute findOneById($id)
 */
class FakeAttributeRepository extends AbstractFakeRepository implements AttributeRepositoryInterface
{
    /** @var Attribute[] */
    protected $entities = [];

    public function __construct()
    {
        $this->setReturnValue(new Attribute);
    }
}
