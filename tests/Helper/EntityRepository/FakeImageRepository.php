<?php
namespace inklabs\kommerce\tests\Helper\EntityRepository;

use inklabs\kommerce\Entity\Image;
use inklabs\kommerce\EntityRepository\ImageRepositoryInterface;

class FakeImageRepository extends AbstractFakeRepository implements ImageRepositoryInterface
{
    public function __construct()
    {
        $this->setReturnValue(new Image);
    }

    public function find($id)
    {
        return $this->getReturnValue();
    }
}
