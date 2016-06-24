<?php
namespace inklabs\kommerce\Service;

use inklabs\kommerce\Entity\Image;
use inklabs\kommerce\EntityDTO\ImageDTO;
use inklabs\kommerce\Exception\EntityNotFoundException;
use inklabs\kommerce\Lib\UuidInterface;

interface ImageServiceInterface
{
    public function create(Image & $image);
    public function update(Image & $image);

    public function createFromDTOWithTag(UuidInterface $tagId, ImageDTO $imageDTO);
    public function createFromDTOWithProduct(UuidInterface $productId, ImageDTO $imageDTO);

    public function setFromDTO(Image & $image, ImageDTO $imageDTO);

    /**
     * @param UuidInterface $id
     * @return Image
     * @throws EntityNotFoundException
     */
    public function findOneById(UuidInterface $id);
}
