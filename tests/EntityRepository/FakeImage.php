<?php
namespace inklabs\kommerce\tests\EntityRepository;

use inklabs\kommerce\EntityRepository\ImageInterface;
use inklabs\kommerce\Entity;
use inklabs\kommerce\View;
use inklabs\kommerce\tests\Helper;

class FakeImage extends Helper\AbstractFake implements ImageInterface
{
    public function __construct()
    {
        $this->setReturnValue(new Entity\Image);
    }

    public function find($id)
    {
        return $this->getReturnValue();
    }

    public function save(Entity\Image & $image)
    {
    }

    public function create(Entity\Image & $image)
    {
    }

    public function persist(Entity\Image & $image)
    {
    }
}
