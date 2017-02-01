<?php
namespace inklabs\kommerce\Service;

use inklabs\kommerce\Entity\Product;
use inklabs\kommerce\Exception\EntityNotFoundException;
use inklabs\kommerce\Lib\UuidInterface;

interface ProductServiceInterface
{
    /**
     * @param UuidInterface $id
     * @return Product
     * @throws EntityNotFoundException
     */
    public function findOneById(UuidInterface $id);
}
