<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity;

class ImageRepository extends AbstractRepository implements ImageRepositoryInterface
{
    public function save(Entity\Image & $image)
    {
        $this->saveEntity($image);
    }

    public function create(Entity\Image & $image)
    {
        $this->createEntity($image);
    }

    public function remove(Entity\Image & $image)
    {
        $this->removeEntity($image);
    }
}
