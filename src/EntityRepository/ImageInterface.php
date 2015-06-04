<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity;

interface ImageInterface
{
    public function save(Entity\Image & $image);
    public function create(Entity\Image & $image);
    public function remove(Entity\Image & $image);

    /**
     * @param int $id
     * @return Entity\Image
     */
    public function find($id);
}
