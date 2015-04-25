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
}
