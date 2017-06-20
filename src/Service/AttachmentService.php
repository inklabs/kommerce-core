<?php
namespace inklabs\kommerce\Service;

use inklabs\kommerce\Entity\Attachment;
use inklabs\kommerce\Entity\UserProductAttachment;
use inklabs\kommerce\EntityDTO\UploadFileDTO;
use inklabs\kommerce\EntityRepository\AttachmentRepositoryInterface;
use inklabs\kommerce\EntityRepository\OrderItemRepositoryInterface;
use inklabs\kommerce\EntityRepository\ProductRepositoryInterface;
use inklabs\kommerce\EntityRepository\UserRepositoryInterface;
use inklabs\kommerce\Lib\FileManagerInterface;
use inklabs\kommerce\Lib\UuidInterface;

class AttachmentService implements AttachmentServiceInterface
{
    use EntityValidationTrait;

    /** @var AttachmentRepositoryInterface */
    private $attachmentRepository;

    /** @var FileManagerInterface */
    private $fileManager;

    /** @var OrderItemRepositoryInterface */
    private $orderItemRepository;

    /** @var ProductRepositoryInterface */
    private $productRepository;

    /** @var UserRepositoryInterface */
    private $userRepository;

    public function __construct(
        AttachmentRepositoryInterface $attachmentRepository,
        FileManagerInterface $fileManager,
        OrderItemRepositoryInterface $orderItemRepository,
        ProductRepositoryInterface $productRepository,
        UserRepositoryInterface $userRepository
    ) {
        $this->attachmentRepository = $attachmentRepository;
        $this->fileManager = $fileManager;
        $this->orderItemRepository = $orderItemRepository;
        $this->productRepository = $productRepository;
        $this->userRepository = $userRepository;
    }

    public function createAttachmentForOrderItem(UploadFileDTO $uploadFileDTO, UuidInterface $orderItemId): void
    {
        $orderItem = $this->orderItemRepository->findOneById($orderItemId);
        $order = $orderItem->getOrder();

        $attachment = $this->createAttachment($uploadFileDTO);

        $orderItem->addAttachment($attachment);
        $this->orderItemRepository->update($order);
    }

    public function createAttachmentForUserProduct(
        UploadFileDTO $uploadFileDTO,
        UuidInterface $userId,
        UuidInterface $productId
    ): void {
        $user = $this->userRepository->findOneById($userId);
        $product = $this->productRepository->findOneById($productId);

        $attachment = $this->createAttachment($uploadFileDTO);

        $userProductAttachment = new UserProductAttachment($user, $product, $attachment);
        $this->attachmentRepository->create($userProductAttachment);
    }

    private function createAttachment(UploadFileDTO $uploadFileDTO): Attachment
    {
        $managedFile = $this->fileManager->saveFile($uploadFileDTO->getFilePath());

        $attachment = new Attachment(
            $managedFile->getUri()
        );

        $this->attachmentRepository->create($attachment);

        return $attachment;
    }
}
