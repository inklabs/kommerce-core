<?php
namespace inklabs\kommerce\tests\Helper\EntityRepository;

use inklabs\kommerce\Entity\Image;
use inklabs\kommerce\EntityRepository\ImageRepositoryInterface;

/**
 * @method Image findOneById($id)
 */
class FakeImageRepository extends AbstractFakeRepository implements ImageRepositoryInterface
{
    public function __construct()
    {
        $this->setReturnValue(new Image);
    }
}
