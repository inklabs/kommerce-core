<?php
namespace inklabs\kommerce\Service;

use inklabs\kommerce\Entity\Image;
use inklabs\kommerce\EntityDTO\ImageDTO;
use inklabs\kommerce\Exception\EntityNotFoundException;
use Ramsey\Uuid\UuidInterface;

interface ImageServiceInterface
{
    public function create(Image & $image);
    public function update(Image & $image);

    /**
     * @param ImageDTO $imageDTO
     * @param UuidInterface $tagId
     */
    public function createFromDTOWithTag(ImageDTO $imageDTO, UuidInterface $tagId);

    /**
     * @param Image $image
     * @param UuidInterface $productId
     * @throws EntityNotFoundException
     */
    public function createWithProduct(Image & $image, UuidInterface $productId);

    public function setFromDTO(Image & $image, ImageDTO $imageDTO);

    /**
     * @param UuidInterface $id
     * @return Image
     * @throws EntityNotFoundException
     */
    public function findOneById(UuidInterface $id);
}
