<?php
namespace inklabs\kommerce\Service;

use inklabs\kommerce\Entity\Image;
use inklabs\kommerce\EntityDTO\ImageDTO;

interface ImageServiceInterface
{
    public function create(Image & $image);
    public function update(Image & $image);
    public function createFromDTO(ImageDTO $imageDTO);
    public function updateFromDTO(ImageDTO $imageDTO);

    /**
     * @param ImageDTO $imageDTO
     * @param int $tagId
     */
    public function createFromDTOWithTag(ImageDTO $imageDTO, $tagId);
}
