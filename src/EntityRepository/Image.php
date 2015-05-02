<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity;

class Image extends AbstractEntityRepository implements ImageInterface
{
    public function save(Entity\Image & $image)
    {
        $this->saveEntity($image);
    }

    public function create(Entity\Image & $image)
    {
        $this->persist($image);
        $this->flush();
    }

    public function persist(Entity\Image & $image)
    {
        $this->persistEntity($image);
    }
}
