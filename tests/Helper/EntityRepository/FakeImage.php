<?php
namespace inklabs\kommerce\tests\Helper\EntityRepository;

use inklabs\kommerce\EntityRepository\ImageInterface;
use inklabs\kommerce\Entity;

class FakeImage extends AbstractFake implements ImageInterface
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
