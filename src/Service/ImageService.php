<?php
namespace inklabs\kommerce\Service;

use inklabs\kommerce\Entity\Image;
use inklabs\kommerce\EntityDTO\UploadFileDTO;
use inklabs\kommerce\EntityRepository\ImageRepositoryInterface;
use inklabs\kommerce\EntityRepository\ProductRepositoryInterface;
use inklabs\kommerce\EntityRepository\TagRepositoryInterface;
use inklabs\kommerce\Lib\FileManagerInterface;
use inklabs\kommerce\Lib\UuidInterface;

class ImageService implements ImageServiceInterface
{
    use EntityValidationTrait;

    /** @var FileManagerInterface */
    private $fileManager;

    /** @var ImageRepositoryInterface */
    private $imageRepository;

    /** @var ProductRepositoryInterface */
    private $productRepository;

    /** @var TagRepositoryInterface */
    private $tagRepository;

    public function __construct(
        FileManagerInterface $fileManager,
        ImageRepositoryInterface $imageRepository,
        ProductRepositoryInterface $productRepository,
        TagRepositoryInterface $tagRepository
    ) {
        $this->imageRepository = $imageRepository;
        $this->productRepository = $productRepository;
        $this->tagRepository = $tagRepository;
        $this->fileManager = $fileManager;
    }

    public function create(Image & $image): void
    {
        $this->imageRepository->create($image);
    }

    public function update(Image & $image): void
    {
        $this->imageRepository->update($image);
    }

    public function createImageForProduct(UploadFileDTO $uploadFileDTO, UuidInterface $productId): void
    {
        $managedFile = $this->fileManager->saveFile($uploadFileDTO->getFilePath());

        $image = new Image(
            $managedFile->getUri(),
            $managedFile->getWidth(),
            $managedFile->getHeight()
        );

        $product = $this->productRepository->findOneById($productId);
        $product->addImage($image);

        $this->create($image);
    }

    public function createImageForTag(UploadFileDTO $uploadFileDTO, UuidInterface $tagId): void
    {
        $managedFile = $this->fileManager->saveFile($uploadFileDTO->getFilePath());

        $image = new Image(
            $managedFile->getUri(),
            $managedFile->getWidth(),
            $managedFile->getHeight()
        );

        $tag = $this->tagRepository->findOneById($tagId);
        $tag->addImage($image);

        $this->create($image);
    }

    public function findOneById(UuidInterface $id): Image
    {
        return $this->imageRepository->findOneById($id);
    }
}
