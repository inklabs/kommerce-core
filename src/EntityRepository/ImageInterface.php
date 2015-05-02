<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity;

interface ImageInterface
{
    /**
     * @param int $id
     * @return Entity\Image
     */
    public function find($id);

    /**
     * @param Entity\Product $product
     */
    public function create(Entity\Image & $image);

    /**
     * @param Entity\Image $image
     */
    public function save(Entity\Image & $image);

    /**
     * @param Entity\Image $image
     */
    public function persist(Entity\Image & $image);

    public function flush();
}
