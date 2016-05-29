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
     * @param int $tagId
     */
    public function createFromDTOWithTag(ImageDTO $imageDTO, $tagId);

    /**
     * @param Image $image
     * @param int $productId
     * @throws EntityNotFoundException
     */
    public function createWithProduct(Image &$image, $productId);

    public function setFromDTO(Image & $image, ImageDTO $imageDTO);

    /**
     * @param UuidInterface $id
     * @return Image
     * @throws EntityNotFoundException
     */
    public function findOneById(UuidInterface $id);
}
