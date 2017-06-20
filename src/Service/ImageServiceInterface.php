<?php
namespace inklabs\kommerce\Service;

use inklabs\kommerce\Entity\Image;
use inklabs\kommerce\EntityDTO\UploadFileDTO;
use inklabs\kommerce\Exception\EntityNotFoundException;
use inklabs\kommerce\Lib\UuidInterface;

interface ImageServiceInterface
{
    public function create(Image & $image): void;
    public function update(Image & $image): void;

    public function createImageForProduct(UploadFileDTO $uploadFileDTO, UuidInterface $productId): void;
    public function createImageForTag(UploadFileDTO $uploadFileDTO, UuidInterface $tagId): void;

    public function findOneById(UuidInterface $id): Image;
}
