<?php
namespace inklabs\kommerce\tests\Helper\EntityRepository;

use inklabs\kommerce\EntityRepository\ImageRepositoryInterface;
use inklabs\kommerce\Entity;

class FakeImageRepository extends AbstractFakeRepository implements ImageRepositoryInterface
{
    public function __construct()
    {
        $this->setReturnValue(new Entity\Image);
    }

    public function save(Entity\Image & $image)
    {
    }

    public function create(Entity\Image & $image)
    {
    }

    public function remove(Entity\Image & $image)
    {
    }

    public function find($id)
    {
        return $this->getReturnValue();
    }
}
