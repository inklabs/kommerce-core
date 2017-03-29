<?php
namespace inklabs\kommerce\Service;

use inklabs\kommerce\Entity\Image;
use inklabs\kommerce\EntityDTO\UploadFileDTO;
use inklabs\kommerce\Exception\EntityNotFoundException;
use inklabs\kommerce\Lib\UuidInterface;

interface ImageServiceInterface
{
    public function create(Image & $image);
    public function update(Image & $image);

    public function createImageForProduct(UploadFileDTO $uploadFileDTO, UuidInterface $productId);
    public function createImageForTag(UploadFileDTO $uploadFileDTO, UuidInterface $tagId);

    /**
     * @param UuidInterface $id
     * @return Image
     * @throws EntityNotFoundException
     */
    public function findOneById(UuidInterface $id);
}
